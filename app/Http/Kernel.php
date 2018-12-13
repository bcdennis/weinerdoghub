<?php namespace Smile\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        'Smile\Http\Middleware\CheckForMaintenanceMode',
        'Illuminate\Cookie\Middleware\EncryptCookies',
        'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
        'Illuminate\Session\Middleware\StartSession',
        'Illuminate\View\Middleware\ShareErrorsFromSession',
        'Smile\Http\Middleware\VerifyCsrfToken',
        'Smile\Http\Middleware\RequestTracker',
        'Smile\Http\Middleware\Language',
        'IonutMilica\LaravelSettings\SavableMiddleware',
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => 'Smile\Http\Middleware\Authenticate',
        'auth.admin' => 'Smile\Http\Middleware\AdminAuthenticate',
        'auth.basic' => 'Illuminate\Auth\Middleware\AuthenticateWithBasicAuth',
        'guest' => 'Smile\Http\Middleware\RedirectIfAuthenticated',
    ];

}
