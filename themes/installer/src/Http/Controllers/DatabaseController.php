<?php

namespace Themes\Installer\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PDO;

class DatabaseController extends InstallerController
{

    /**
     * Check database details
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function check(Request $request)
    {
        $this->validate($request, [
            'database' => 'required',
            'host' => 'required',
            'username'  => 'required',
            'port' => 'required',
        ]);

        $host = $request->get('host');
        $user = $request->get('username');
        $pass = $request->get('password');
        $db = $request->get('database');
        $port = $request->get('port');
        $update = $request->get('update', false);

        $tries = 3;
        $isOk = false;

        while ($tries--) {
            if ($this->tryConnection($host, $db, $user, $pass, $port)) {
                $isOk = true;
            }
        }

        if ( ! $isOk) {
            return redirect()->back()->withErrors([
                'general' => 'Invalid credentials!',
            ]);
        }

        $request->session()->set('just-update', $update);
        $request->session()->set('install.done.database', true);

        $request->session()->save();


        $this->writeEnvFile(compact('host', 'user', 'pass', 'db', 'port'));

        return redirect()->route('email');
    }

    /**
     * Get started page
     *
     * @return \Illuminate\View\View
     */
    public function page()
    {
        if ($response = $this->ensureSteps('license|requirements')) {
            return $response;
        }

        return $this->view('steps.database');
    }

    /**
     * Check if we can connect
     *
     * @param $host
     * @param $db
     * @param $user
     * @param $pass
     * @param $port
     * @return bool
     */
    protected function tryConnection($host, $db, $user, $pass, $port)
    {
        $isOk = true;

        $dsn = 'mysql:host='.$host.';dbname='.$db.';port='.$port.'charset=utf8';
        $opt = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

        try {
            new PDO($dsn, $user, $pass, $opt);
        } catch (Exception $e) {
            $isOk = false;
        }

        return $isOk;
    }

    /**
     * Write the env file
     *
     * @param array $data
     */
    protected function writeEnvFile(array $data)
    {
        $env = file_get_contents(base_path('.env.install'));

        foreach ($data as $field => $value) {
            $env = str_replace('*'.$field.'*', $value, $env);
        }
        $env = str_replace('*url*', url(), $env);

        file_put_contents(base_path('.env'), $env);
    }

}
