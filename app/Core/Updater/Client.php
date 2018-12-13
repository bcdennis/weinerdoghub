<?php

namespace Smile\Core\Updater;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;

class Client
{
    const URL = 'http://bitempest.com/api';

    /**
     * @var
     */
    private $client;

    /**
     * @param GuzzleClient $client
     */
    public function __construct(GuzzleClient $client)
    {
        $this->client = $client;
    }

    /**
     * Validate update key
     *
     * @param $key
     * @return bool
     */
    public function validate($key)
    {
        $data = null;

        try {
            $data = $this->send('check', ['license' => $key]);
        } catch (ConnectException $e) {
            $data = true;
        } catch (ServerException $e) {
            $data = true;
        } catch (\Exception $e) {
            $data = null;
        }

        if (is_object($data)) {
            $data = $data->json();
        }

        if ($data === null) {
            return false;
        }

        return true;
    }

    /**
     * Check for version
     *
     * @param $key
     * @return string
     */
    public function version($key)
    {
        $version = '0.0.0';

        try {
            $data = $this->send('version', ['license' => $key]);

            if (is_object($data)) {
                $version = $data->json()['version'];
            }
        } catch (\Exception $e) {

        }

        return $version;
    }

    /**
     * Confirm cmd
     *
     * @param $cmd
     * @param $code
     * @return bool
     */
    public function confirmCmd($cmd, $code)
    {
        $status = true;

        try {
            $this->send('cmd', [
                'cmd' => $cmd,
                'code' => $code,
            ]);
        } catch (\Exception $e) {
            $status = false;
        }

        return $status;
    }

    /**
     * Make requests
     *
     * @param $url
     * @param array $data
     * @return \GuzzleHttp\Message\FutureResponse|\GuzzleHttp\Message\ResponseInterface|\GuzzleHttp\Ring\Future\FutureInterface|null
     */
    protected function send($url, array $data = [])
    {
        return $this->client->post(self::URL.'/'.$url, [
            'headers' => [
                'X-Requested-With' => 'XMLHttpRequest',
            ],
            'body' => array_merge([
                'url' => url(),
                'ip' => isset($_SERVER['LOCAL_ADDR']) ? $_SERVER['LOCAL_ADDR'] : $_SERVER['SERVER_ADDR'],
                'product' => 'smile-v'.VERSION
            ], $data)
        ]);
    }

}
