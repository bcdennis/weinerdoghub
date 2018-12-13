<?php

namespace Smile\Core\Extensions\Controllers;

use Illuminate\Routing\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AssetsController extends Controller
{

    /**
     * Serve extensions assets
     *
     * @param $extension
     * @param $file
     * @return string
     */
    public function serve($extension, $file)
    {
        $file = base_path(sprintf('extensions/%s/resources/assets/%s', $extension, $file));
        $file = $this->cleanPath($file);
        $type = $this->getType($file);

        if (is_file($file)) {
            return response(file_get_contents($file))->header('Content-Type', $type);
        }

        throw new NotFoundHttpException();
    }


    /**
     * Clean path
     *
     * @param $path
     * @return mixed
     */
    protected function cleanPath($path)
    {
        while (substr_count($path, '..')) {
            $path = str_replace('..', '', $path);
        }

        $path = str_replace('//', '/', $path);

        return $path;
    }

    /**
     * Get the content type of a file
     *
     * @param $file
     * @return string
     */
    protected function getType($file)
    {
        if (ends_with($file, '.css')) {
            return 'text/css';
        }

        if (ends_with($file, '.js')) {
            return 'application/javascript';
        }

        if (ends_with($file, '.png')) {
            return 'image/png';
        }

        if (ends_with($file, '.jpg') || ends_with($file, '.jpeg')) {
            return 'image/jpeg';
        }

        return 'text/plain';
    }

}
