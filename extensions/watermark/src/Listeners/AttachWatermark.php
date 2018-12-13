<?php namespace Extensions\Watermark\Listeners;

use IonutMilica\LaravelSettings\SettingsContract;
use Exception;
use Intervention\Image\ImageManager;
use Smile\Events\Post\BeforeMediaUpload;

class AttachWatermark
{
    /**
     * @var ImageManager
     */
    private $imageManager;

    /**
     * @var SettingsContract
     */
    private $settings;

    /**
     * @param ImageManager $imageManager
     * @param SettingsContract $settings
     */
    public function __construct(ImageManager $imageManager, SettingsContract $settings)
    {
        $this->imageManager = $imageManager;
        $this->settings = $settings;
    }

    /**
     * Intercept the upload and append a watermark to the original image
     *
     * @param BeforeMediaUpload $event
     * @throws Exception
     */
    public function handle(BeforeMediaUpload $event)
    {
        $watermark = $this->getWatermark();

        if ($watermark == null) {
            // If there is no provided image just silently abort
            //@TODO: Log this fail into the admin panel
            return ;
        }

        $watermarkPos = $this->settings->get('watermark.position', 'top-center');
        $watermarkOffsetX = $this->settings->get('watermark.offset.x', 0);
        $watermarkOffsetY = $this->settings->get('watermark.offset.y', 0);

        $event->thumbnail->insert($watermark, $watermarkPos, $watermarkOffsetX, $watermarkOffsetY);
        $event->media->insert($watermark, $watermarkPos, $watermarkOffsetX, $watermarkOffsetY);
    }

    /**
     * Get watermark object
     *
     * @return \Intervention\Image\Image
     */
    protected function getWatermark()
    {
        $rotation = $this->settings->get('watermark.rotation', 0);
        $image = $this->settings->get('watermark.image');

        if ($image == null) {
            return null;
        }

        return $this->imageManager->make($image)->rotate($rotation);
    }

}
