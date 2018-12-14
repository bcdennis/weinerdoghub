<?php

namespace Smile\Http\Controllers\Installer;

use Illuminate\Http\Request;

class RequirementsController extends InstallerController
{
    /**
     * Get started page
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function page(Request $request)
    {
        if ($response = $this->ensureSteps($request, 'license')) {
            return $response;
        }

        $hasOpenSSL = extension_loaded('openssl');
        $hasFileInfo = extension_loaded('fileinfo');
        $hasGd = extension_loaded('gd') && function_exists('gd_info');
        $hasPdo = class_exists('PDO');
        $storageIsWritable = is_writable(storage_path());
        $uploadsIsWritable = is_writable(public_path('uploads'));
        $extensionsIsWritable = is_writable(public_path('extensions'));
        $envExists = is_file(base_path('.env'));
        $envWritable = $envExists ? is_writable(base_path('.env')) : false;
        $allowUrlFopen = (bool)ini_get('allow_url_fopen');


        $data = [
            'phpVersion' => [
                'needed' => phpversion(),
                'ok' => !version_compare(phpversion(), '7.0.0', '<')
            ],
            'openssl' => [
                'needed' => !$hasOpenSSL ? 'not found' : 'found',
                'ok' => $hasOpenSSL
            ],
            'gd' => [
                'needed' => !$hasGd ? 'not found' : 'found',
                'ok' => $hasGd
            ],
            'pdo' => [
                'needed' => !$hasPdo ? 'not found' : 'found',
                'ok' => $hasPdo
            ],
            'storage' => [
                'needed' => storage_path() . ($storageIsWritable ? ' is writable' : ' is not writable'),
                'ok' => $storageIsWritable
            ],
            'uploads' => [
                'needed' => public_path('uploads') . ($uploadsIsWritable ? ' is writable' : ' is not writable'),
                'ok' => $uploadsIsWritable
            ],
            'extensions' => [
                'needed' => public_path('extensions') . ($extensionsIsWritable ? ' is writable' : ' is not writable'),
                'ok' => $extensionsIsWritable
            ],
            'env' => [
                'needed' => base_path('.env') . ($envExists ? ($envWritable ? ' is writable' : ' is not writable') : ' does not exist'),
                'ok' => $envExists ? $envWritable : false,
            ],
            'allowUrlFopen' => [
                'needed' => $allowUrlFopen ? ' is enabled' : ' is not enabled',
                'ok' => $allowUrlFopen,
            ],
            'fileinfo' => [
                'needed' => $hasFileInfo ? ' found' : 'not found',
                'ok' => $hasFileInfo,
            ]
        ];
        $canContinue = $this->canGoNext($data);
        $data['next'] = $canContinue;

        if ($canContinue) {
            $request->session()->put('install.done.requirements', true);
        } else {
            $request->session()->forget('install.done.requirements');
        }

        return $this->view('steps.requirements', $data);
    }

    /**
     * Check if installer can go to the next step
     *
     * @param array $requirements
     * @return bool
     */
    protected function canGoNext(array $requirements)
    {
        foreach ($requirements as $requirement) {
            if ($requirement['ok'] == false) {
                return false;
            }
        }

        return true;
    }

}
