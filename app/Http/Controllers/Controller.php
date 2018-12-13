<?php namespace Smile\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController
{

    use DispatchesCommands, ValidatesRequests;

    /**
     * View for current theme
     *
     * @param $view
     * @param array $data
     * @return \Illuminate\View\View
     */
    public abstract function view($view, array $data = []);

    /**
     * Json response
     *
     * @param array $data
     * @param int $code
     * @return JsonResponse
     */
    public function json(array $data, $code = 200)
    {
        return new JsonResponse($data, $code);
    }

    /**
     *
     *
     * @param $error
     * @param int $code
     * @return JsonResponse
     */
    public function respondWithError($error, $code = 422)
    {
        return new JsonResponse(['general' => $error], $code);
    }

    /**
     * Json errors
     *
     * @param array $data
     * @param int $code
     * @return JsonResponse
     */
    public function jsonErrors(array $data, $code = 422)
    {
        return new JsonResponse($data, $code);
    }

    /**
     * Get view for selected theme
     *
     * @param $theme
     * @param $view
     * @param array $data
     * @return \Illuminate\View\View
     */
    public function themeView($theme, $view, $data = [])
    {
        return view(sprintf('%s::%s', $theme, $view), $data);
    }
}
