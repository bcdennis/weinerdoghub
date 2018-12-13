<?php

namespace Themes\Installer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Smile\Core\Persistence\Repositories\UserContract;
use Symfony\Component\HttpFoundation\JsonResponse;

class FinishController extends InstallerController
{

    /**
     * Save email settings
     *
     * @param Request $request
     * @return mixed
     */
    public function save(Request $request)
    {
        $license = $request->session()->get('install.done.license');

        if ( ! session('just-update')) {
            $env = file_get_contents(base_path('.env'));
            $environment = 'production';
            $debug = 'false';

            if ($request->has('dev')) {
                $environment = 'local';
                $debug = 'true';
            }

            $env = str_replace(['*environment*', '*debug*'], [$environment, $debug], $env);
            file_put_contents(base_path('.env'), $env);

            Artisan::call('key:generate');
            Artisan::call('db:seed', [
                '--force' => true,
            ]);

            $this->defaultSettings();
            $goTo = redirect()->route('home');
        } else {
            $goTo = redirect('/upgrade');
        }

        $this->setting->set('license', $license);

        file_put_contents(storage_path('app/.installed'), '');
        file_put_contents(storage_path('app/.license'), $license);

        return $goTo;
    }

    /**
     * Default installation settings
     */
    protected function defaultSettings()
    {
        $this->setting->set('branding.title', 'Smile | Your daily dose of joy');
        $this->setting->set('branding.description', 'Smile has the best funny pics, GIFs and videos on the web. Smile is your best source of happiness.');
        $this->setting->set('branding.keywords', 'smile, funny, lol, meme, GIF, omg, fail, video, cosplay, geeky');
        $this->setting->set('branding.copyright', 'Smile :) &copy; 2015');
        $this->setting->set('branding.url-format', 'smile/{post}');
        $this->setting->set('bronze-lvl', '50000');
        $this->setting->set('maximum-categories', '2');
        $this->setting->set('platinum-lvl', '500000');
        $this->setting->set('gold-lvl', '250000');
        $this->setting->set('silver-lvl', '100000');
        $this->setting->set('avatar-size', '3072');
        $this->setting->set('image-size', '3072');
        $this->setting->set('post-size', '100');

        foreach (session('install.email', []) as $field => $value) {
            $this->setting->set('email.'.$field, $value);
        }

        session()->remove('install');
    }

    /**
     * Get started page
     *
     * @return \Illuminate\View\View
     */
    public function page()
    {
        if ($response = $this->ensureSteps('license|requirements|database|admin')) {
            return $response;
        }

        return $this->view('steps.finish');
    }

}
