<?php namespace Smile\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class Language {

    /**
     * Create a new filter instance.
     */
	public function __construct()
	{
    }

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        if (php_sapi_name() == 'cli' || ! INSTALLED) {
            return $next($request);
        }

        $user = auth()->user();

        if ($user && $user->language) {
            App::setLocale($user->language);
        }

		return $next($request);
	}

}
