<?php
namespace Smile\Core\Image;

use Illuminate\Contracts\Filesystem\Filesystem;
use Intervention\Image\ImageManager;
use Smile\Core\Contracts\Image\UploaderContract;
use Smile\Events\Post\BeforeMediaUpload;
use Smile\Core\Persistence\Models\Category;
use Smile\Core\Persistence\Models\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Uploader implements UploaderContract
{
    /**
     * @var ImageManager
     */
    private $imageManager;
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @param ImageManager $imageManager
     * @param Filesystem $filesystem
     */
    public function __construct(ImageManager $imageManager, Filesystem $filesystem)
    {
        $this->imageManager = $imageManager;
        $this->filesystem = $filesystem;
    }

    /**
     * Remove image from url
     *
     * @param $url
     */
    public function remove($url)
    {
        if ($this->filesystem->exists($url)) {
            $this->filesystem->delete($url);
        }
    }

    /**
     * Delete avatar from the server
     *
     * @param User $user
     */
    public function removeAvatar(User $user)
    {
        $this->filesystem->delete($user->avatar);
    }

    /**
     * Upload user avatar
     *
     * TODO: Avatar size should be changed from the configuration file
     *
     * @param User $user
     * @param UploadedFile|string $file
     * @return string
     */
    public function avatar(User $user, $file)
    {
        $file = ! is_object($file) ? explode('?', $file)[0] : $file;
        $name = sprintf('user_%d', $user->id);
        $extension = $this->getExtension($file);

        $format = sprintf('uploads/profile/%s.%s', $name, $extension);

        $image = $this->imageManager->make($this->getPath($file))->resize(105, 105);
        $this->filesystem->put($format, (string) $image->encode());

        return $format;
    }

    /**
     * Upload icon for category
     *
     * @param Category $category
     * @param $file UploadedFile
     * @return string
     */
    public function icon(Category $category, UploadedFile $file)
    {
        $extension = $this->getExtension($file);

        $format = sprintf('uploads/categories/%s.%s', $category->id, $extension);

        $image = $this->imageManager->make($this->getPath($file));
        $this->filesystem->put($format, (string) $image->encode());

        return $format;
    }

    /**
     * Remove icon from the server
     *
     * @param Category $category
     */
    public function removeIcon(Category $category)
    {
        $this->filesystem->delete($category->icon);
    }

    /**
     * Upload post image
     *
     * @param array $data
     * @return array
     */
    public function uploadPostImage(array $data)
    {
        $wasResized = false;
        $file = $data['media'];
        $path = $this->getPath($file);
        $ext = $this->getExtension($file);
        $name = sprintf('%s.%s', $data['slug'], $ext);

        $data['type'] = $ext == 'gif' ? 'gif' : 'image';

        if ($data['type'] == 'gif') {
            return $this->uploadGif($name, $data);
        }

        list($smallDir, $thumbDir, $bigDir) = $this->directories();

        $thumbnail = $this->thumbnail($path, $wasResized);
        $big = $this->media($path);

        if ($wasResized) {
            $small = clone $thumbnail;
            $small->fit(261, 126);
        } else {
            $small = $this->featured($path);
        }

        event(new BeforeMediaUpload($small, $thumbnail, $big));

        $this->filesystem->put($bigDir.$name, (string) $big->encode());
        $this->filesystem->put($smallDir.$name, (string) $small->encode());
        $this->filesystem->put($thumbDir.$name, (string) $thumbnail->encode());

        $data['resized'] = $wasResized;
        $data['media'] = $bigDir.$name;
        $data['featured'] = $smallDir.$name;
        $data['thumbnail'] = $thumbDir.$name;

        return $data;
    }

    /**
     * Upload gif image
     *
     * @param $name
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function uploadGif($name, array $data)
    {
        $file = $data['media'];

        list($smallDir, $thumbDir, $bigDir) = $this->directories();

        if (setting('conversion.on') && function_exists('shell_exec')) {
            if ( ! is_object($file)) {
                $temp = $this->tempPath($data['slug']);
                copy($file, $temp);
                $file = new UploadedFile($temp, $data['slug']);
            }
            $data['type'] = 'video';

            // Temp files
            $tempFrame = $this->tempPath($data['slug'].'.png');
            $tempMp4 = $this->tempPath($data['slug'].'.mp4');
            $tempwebM = $this->tempPath($data['slug'].'.webm');

            $converter = setting('conversion.binaries.ffmpeg', '/opt/ffmpeg/bin/ffmpeg');

            shell_exec(sprintf('%s -i %s -pix_fmt yuv420p -vf scale=-2:720 %s', $converter, $file->getRealPath(), $tempMp4));
            shell_exec(sprintf('%s -i %s -c:v libvpx -crf 12 -b:v 500K  %s', $converter, $file->getRealPath(), $tempwebM));
            shell_exec(sprintf('%s -i %s -ss 00:00:00.000 -vframes 1 %s', $converter, $tempwebM, $tempFrame));

            $featured = $this->featured($tempFrame);
            $thumbnail = $this->thumbnail($tempFrame, $resized);

            // Move the videos to the uploads
            $this->filesystem->put($bigDir.$data['slug'].'.mp4', file_get_contents($tempMp4));
            $this->filesystem->put($bigDir.$data['slug'].'.webm', file_get_contents($tempwebM));

            $this->filesystem->put($bigDir.$data['slug'].'.jpeg', file_get_contents($tempFrame));
            $this->filesystem->put($smallDir.$data['slug'].'.jpeg', (string) $featured->encode());
            $this->filesystem->put($thumbDir.$data['slug'].'.jpeg', (string) $thumbnail->encode());

            $data['media'] = $bigDir.$data['slug'].'.jpeg';
            $data['thumbnail'] = $thumbDir.$data['slug'].'.jpeg';
            $data['featured'] = $smallDir.$data['slug'].'.jpeg';

            if (isset($temp)) unlink($temp);
            unlink($tempFrame);
            unlink($tempMp4);
            unlink($tempwebM);
        } else {
            $data['type'] = 'gif';

            $thumbnail = $this->thumbnail($file, $resized);
            $featured = $this->featured($file);

            $this->filesystem->put($bigDir.$name, file_get_contents($this->getPath($file)));
            $this->filesystem->put($smallDir.$name, (string) $featured->encode());
            $this->filesystem->put($thumbDir.$name, (string) $thumbnail->encode());

            // Register data
            $data['media'] = $bigDir.$name;
            $data['thumbnail'] = $thumbDir.$name;
            $data['featured'] = $smallDir.$name;

        }

        return $data;
    }

    /**
     * Helper for small image uploading
     *
     * @param array $data
     * @param $url
     * @return string
     */
    public function uploadSmallImage(array $data, $url)
    {
        $name = sprintf('post_%s.jpg', $data['slug']);
        $date = sprintf('%s/%s', date('Y'), date('m'));

        $format = 'uploads/posts/%s/'.$date.'/';
        $smallDir = sprintf($format, 'small');

        $this->ensureDirectoryExistence($smallDir);

        $small = $this->featured($url);
        $this->filesystem->put($smallDir.$name, (string) $small->encode());

        return $smallDir.$name;
    }

    /**
     * Temporary path
     *
     * @param $file
     * @return string
     */
    protected function tempPath($file)
    {
        return storage_path('app/'.$file);
    }

    /**
     * Get featured object
     *
     * @param $path
     * @return \Intervention\Image\Image
     */
    protected function featured($path)
    {
        return $this->imageManager->make($path)->fit(261, 126);
    }

    /**
     * Get thumbnail object
     *
     * @param $path
     * @param $resized
     * @return \Intervention\Image\Image
     */
    protected function thumbnail($path, &$resized)
    {
        $thumbnail = $this->imageManager->make($path);

        if ($thumbnail->getWidth() != 640) {
            $thumbnail = $thumbnail->widen(640);
        }

        if ($thumbnail->getHeight() > 1200) {
            $thumbnail = $thumbnail->crop(640, 384, 0, 0);
            $resized = true;
        }

        return $thumbnail;
    }

    /**
     * Get media object
     *
     * @param $path
     * @return \Intervention\Image\Image
     */
    protected function media($path)
    {
        $media = $this->imageManager->make($path);

        if ($media->getWidth() != 640) {
            $media = $media->widen(640);
        }

        return $media;
    }

    /**
     * Get directories
     *
     * @return array
     */
    protected function directories()
    {
        $format = 'uploads/posts/%s/'.date('Y').'/'.date('m').'/';

        $smallDir = sprintf($format, 'small');
        $bigDir = sprintf($format, 'big');
        $thumbDir = sprintf($format, 'thumbnail');

        $this->ensureDirectoryExistence($smallDir);
        $this->ensureDirectoryExistence($bigDir);
        $this->ensureDirectoryExistence($thumbDir);

        return [$smallDir, $thumbDir, $bigDir];
    }

    /**
     * Get path from file
     *
     * @param $file
     * @return string
     */
    protected function getPath($file)
    {
        return ($file instanceof UploadedFile) ? $file->getRealPath() : $file;
    }

    /**
     * Get extension for uploaded file or url
     *
     * @param $file
     * @return mixed|string
     */
    protected function getExtension($file)
    {
        if ($file instanceof UploadedFile) {
            return $file->getClientOriginalExtension();
        }

        return pathinfo($file, PATHINFO_EXTENSION);
    }

    /**
     * Creates directory if it does not exists
     *
     * @param $directory
     * @return bool
     */
    protected function ensureDirectoryExistence($directory)
    {
        return $this->filesystem->makeDirectory($directory);
    }

}
