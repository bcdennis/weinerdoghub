<?php namespace Smile\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RouteServiceProvider extends ServiceProvider {

    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Smile\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        parent::boot($router);

        $router->bind('post', function ($value) {
            $postRepo = $this->app->make('Smile\Core\Persistence\Repositories\PostContract');

            $post = $postRepo->findWithRelationships($value, auth()->user());

            if ( ! $post) {
                throw new NotFoundHttpException;
            }

            return $post;
        });

        $router->bind('user', function ($value) {
            $userService = $this->app->make('Smile\Core\Services\UserService');
            $user = $userService->getByName($value);

            if ( ! $user) {
                throw new NotFoundHttpException;
            }

            return $user;
        });
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function(Router $router)
        {
            if (INSTALLED) {
                $router->group(['namespace' => 'Api', 'prefix' => 'api'], function ($router) {
                    require app_path('Http/api.php');
                });
            }

        });
    }

}
