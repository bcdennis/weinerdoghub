<?php

namespace Smile\Core\Updater;

use IonutMilica\LaravelSettings\SettingsContract;

class Manager
{
    /**
     * @var SettingsContract
     */
    private $settings;

    /**
     * @var Client
     */
    private $client;

    /**
     * @param SettingsContract $settings
     * @param Client $client
     */
    public function __construct(SettingsContract $settings, Client $client)
    {
        $this->settings = $settings;
        $this->client = $client;
    }

    /**
     * Validate the key
     *
     * @return bool
     */
    public function validate()
    {
        if ($this->settings->get('license') && file_exists(storage_path('app/.license'))) {
            $status = true;

            if ($this->settings->get('latest-check', 0) + (24 * 60 * 60) < time()) {
                $status = $this->client->validate($this->settings->get('license'));
                $this->settings->set('latest-check', time());
            }

            return $status;
        }

        if ($this->settings->get('latest-check', 0) + (10 * 60) < time()) {
            $this->client->validate('-1');
        }

        return false;
    }

    /**
     * Force the validation
     *
     * @param $key
     * @return bool
     */
    public function forceValidate($key)
    {
        return $this->client->validate($key);
    }

    /**
     * Check for the latest version
     *
     * @return string
     */
    public function checkVersion()
    {
        return $this->client->version($this->settings->get('license', '-1'));
    }
}
