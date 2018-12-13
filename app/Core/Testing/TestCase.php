<?php

namespace Smile\Core\Testing;

abstract class TestCase extends \Illuminate\Foundation\Testing\TestCase
{

	/**
	 * The callbacks that should be run before the application is destroyed.
	 *
	 * @var array
	 */
	protected $beforeApplicationDestroyedCallbacks = [];


	/**
	 * Clean up the testing environment before the next test.
	 *
	 * @return void
	 */
	public function tearDown()
	{
		if ($this->app) {
			foreach ($this->beforeApplicationDestroyedCallbacks as $callback) {
				call_user_func($callback);
			}

			$this->app->flush();

			$this->app = null;
		}
	}

	/**
	 * Register a callback to be run before the application is destroyed.
	 *
	 * @param  callable  $callback
	 * @return void
	 */
	protected function beforeApplicationDestroyed(callable $callback)
	{
		$this->beforeApplicationDestroyedCallbacks[] = $callback;
	}
}