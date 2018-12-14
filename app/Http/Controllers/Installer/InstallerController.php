<?php

namespace Smile\Http\Controllers\Installer;

use Illuminate\Http\Request;
use IonutMilica\LaravelSettings\SettingsContract;
use Smile\Core\Updater\Client;
use Smile\Http\Controllers\Controller;

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
     * Get view for selected theme
     *
     * @param $view
     * @param array $data
     * @return \Illuminate\View\View
     */
    public function view($view, array $data = [])
    {
        return view("installer.${view}", $data);
    }

    /**
     * Ensure that steps are done
     *
     * @param Request $request
     * @param $step
     * @return \Illuminate\Foundation\Application|mixed
     */
    protected function ensureSteps(Request $request, $step)
    {
        $steps = explode('|', $step);

        foreach ($steps as $step) {
            if (!$request->session()->has('install.done.' . $step)) {
                return redirect()->route($step);
            }
        }

        return null;
    }

}
