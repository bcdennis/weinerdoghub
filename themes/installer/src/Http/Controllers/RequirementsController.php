<?php
namespace Themes\Installer\Http\Controllers;

class RequirementsController extends InstallerController
{

    /**
     * Get started page
     *
     * @return \Illuminate\View\View
     */
    public function page()
    {
        if ($response = $this->ensureSteps('license')) {
            return $response;
        }

        $hasMcrypt = extension_loaded('mcrypt');
        $hasFileInfo = extension_loaded('fileinfo');
        $hasGd = extension_loaded('gd') && function_exists('gd_info');
        $hasPdo = class_exists('PDO');
        $storageIsWritable = is_writable(storage_path());
        $uploadsIsWritable = is_writable(public_path('uploads'));
        $extensionsIsWritable = is_writable(public_path('extensions'));
        $envExists = is_file(base_path('.env'));
        $envWritable = $envExists ? is_writable(base_path('.env')) : false;
        $allowUrlFopen = (bool) ini_get('allow_url_fopen');



        $data = [
            'phpVersion' => [
                'needed' => phpversion(),
                'ok'     => ! version_compare(phpversion(), '5.4.0', '<')
            ],
            'mcrypt' => [
                'needed' => ! $hasMcrypt ? 'not found' : 'found',
                'ok'     => $hasMcrypt
            ],
            'gd' => [
                'needed' => ! $hasGd ? 'not found' : 'found',
                'ok'     => $hasGd
            ],
            'pdo' => [
                'needed' => ! $hasPdo ? 'not found' : 'found',
                'ok'     => $hasPdo
            ],
            'storage' => [
                'needed' => storage_path() . ($storageIsWritable ? ' is writable' : ' is not writable'),
                'ok'     => $storageIsWritable
            ],
            'uploads' => [
                'needed' => public_path('uploads') . ($uploadsIsWritable ? ' is writable' : ' is not writable'),
                'ok'     => $uploadsIsWritable
            ],
            'extensions' => [
                'needed' => public_path('extensions') . ($extensionsIsWritable ? ' is writable' : ' is not writable'),
                'ok'     => $extensionsIsWritable
            ],
            'env' => [
                'needed' => base_path('.env') . ($envExists ? ($envWritable ? ' is writable' : ' is not writable') : ' does not exist'),
                'ok'     => $envExists ? $envWritable : false,
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

        $data['next'] = $this->canGoNext($data);

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
                session()->forget('install.done.requirements');
                return false;
            }
        }

        session(['install.done.requirements' => true]);

        return true;
    }

}
