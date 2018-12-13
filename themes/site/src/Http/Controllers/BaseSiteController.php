<?php

namespace Themes\Site\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Smile\Http\Controllers\Controller;

abstract class BaseSiteController extends Controller
{
	/**
	 * Execute an action on the controller.
	 *
	 * @param  string  $method
	 * @param  array   $parameters
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function callAction($method, $parameters)
	{
        $user = auth()->user();

        $notification = app('Smile\Core\Persistence\Repositories\NotificationContract');

        View::share('unread', $notification->countUnOpened($user));
        View::share('notifications', $notification->search($user));
        View::share('categories', app('Smile\Core\Persistence\Repositories\CategoryContract')->allActive());
        View::share('featured', app('Smile\Core\Services\PostService')->featured(10, $user));


		return parent::callAction($method, $parameters);
	}

    /**
     * Get view for selected theme
     *
     * @param $view
     * @param array $data
     * @return \Illuminate\View\View
     */
    public function view($view, array $data = [])
    {
        $theme = config('smile.theme', 'smile');

        return $this->themeView($theme, $view, $data);
    }

    /**
     * Generate a json response with pagination
     *
     * @param $paginator
     * @return array
     */
    protected function jsonPagination($paginator, $view)
    {
        return [
            'count' => $paginator->count(),
            'total' => $paginator->total(),
            'last' => $paginator->lastPage(),
            'partial' => $view->render()
        ];
    }
}
