<?php
namespace Extensions\Embed;

use Exception;
use Smile\Core\Embed\BaseEmbedder;

class Vine extends BaseEmbedder
{

    /**
     * Embed the video
     *
     * @param array $data
     * @return mixed|void
     * @throws Exception
     */
    protected function embed(array& $data)
    {
        $data['type'] = 'vine';
        $data['media'] = $this->out[1];
        $apiUrl = 'https://archive.vine.co/posts/'.$data['media'].'.json';

        if (!$this->checkIfUrlExists($apiUrl)) {
            throw new Exception('not found');
        }

        $vineJson = @file_get_contents($apiUrl);
        if (!$vineJson) {
            throw new Exception('not found');
        }

        $vine = json_decode($vineJson);

        return $vine->thumbnailUrl;
    }

    /**
     * Regex needed for embedding detection
     *
     * @return mixed
     */
    public function regex()
    {
        return 'https?://vine.co/v/(\w+)';
    }

    /**
     * Check if a given vine url is accessible
     *
     * @param $url
     * @return bool
     */
    private function checkIfUrlExists($url) {
        $headers = get_headers($url);
        return ((int) substr($headers[0], 9, 3)) === 200;
    }
}
