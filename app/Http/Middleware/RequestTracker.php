<?php namespace Smile\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Cookie\CookieJar;
use Smile\Core\Persistence\Repositories\StatContract;

class RequestTracker {
    /**
     * @var CookieJar
     */
    private $cookieJar;
    /**
     * @var StatContract
     */
    private $stat;

    /**
     * Create a new filter instance.
     *
     * @param CookieJar $cookieJar
     * @param StatContract $stat
     */
	public function __construct(CookieJar $cookieJar, StatContract $stat)
	{
        $this->cookieJar = $cookieJar;
        $this->stat = $stat;
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

        $lastUpdate = $request->cookie('last_visit');

        if ( ! $lastUpdate || $lastUpdate->day != Carbon::now()->day) {
            $this->stat->increment('visits');
            $cookie = $this->cookieJar->forever('last_visit', Carbon::now());
            $this->cookieJar->queue($cookie);
        }

		return $next($request);
	}

}
