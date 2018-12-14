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
            $content = $data->getBody()->getContents();
            $data = json_decode($content);
        }

        if ($data === null) {
            return false;
        }

        return true;
    }

    /**
     * Make requests
     *
     * @param $url
     * @param array $data
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function send($url, array $data = [])
    {
        return $this->client->post(self::URL . '/' . $url, [
            'headers' => [
                'X-Requested-With' => 'XMLHttpRequest',
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'json' => array_merge([
                'url' => url('/'),
                'ip' => isset($_SERVER['LOCAL_ADDR']) ? $_SERVER['LOCAL_ADDR'] : $_SERVER['SERVER_ADDR'],
                'product' => 'smile-v' . VERSION
            ], $data)
        ]);
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
                $content = $data->getBody()->getContents();
                $json = json_decode($content, 1);
                $version = isset($json['version']) ? $json['version'] : null;
            }
        } catch (\Exception $e) {
            //
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

}
