<?php

namespace Themes\Installer\Http\Controllers;

use IonutMilica\LaravelSettings\SettingsContract;
use Smile\Http\Controllers\Controller;
use Smile\Core\Updater\Client;

abstract class InstallerController extends Controller
{

    /**
     * @var SettingsContract
     */
    protected $setting;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @param SettingsContract $setting
     * @param Client $client
     */
    public function __construct(SettingsContract $setting, Client $client)
    {
        $this->setting = $setting;
        $this->client = $client;
    }

    /**
     * Ensure that steps are done
     *
     * @param $step
     * @return \Illuminate\Foundation\Application|mixed
     */
    protected function ensureSteps($step)
    {
        $steps = explode('|', $step);

        foreach ($steps as $step) {
            if ( ! session('install.done.'.$step)) {
                return redirect()->route($step);
            }
        }

        return null;
    }

    /**
     * View for current theme
     *
     * @param $name
     * @param array $data
     * @return \Illuminate\View\View
     */
    public function view($name, array $data = [])
    {
        return $this->themeView('installer', $name, $data);
    }

}
