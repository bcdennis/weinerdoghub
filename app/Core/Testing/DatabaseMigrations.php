<?php

namespace Smile\Core\Testing;

trait DatabaseMigrations
{
	/**
	 * @before
	 */
	public function runDatabaseMigrations()
	{
		$this->artisan('migrate');

		$this->beforeApplicationDestroyed(function () {
			$this->artisan('migrate:rollback');
		});
	}
}