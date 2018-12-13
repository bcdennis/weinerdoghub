<?php
namespace Extensions\Embed;

use Exception;
use Smile\Core\Embed\BaseEmbedder;

class DailyMotion extends BaseEmbedder
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
        $data['type'] = 'dmotion';
        $data['media'] = $this->out[1];

        $image = file_get_contents('https://api.dailymotion.com/video/'.$data['media'].'?fields=thumbnail_large_url');
        $json = json_decode($image, 1);

        if (isset($json['error'])) {
            throw new \Exception('Not found');
        }

        return $json['thumbnail_large_url'];
    }

    /**
     * Regex needed for embedding detection
     *
     * @return mixed
     */
    public function regex()
    {
        return 'https?://www.dailymotion.com/video/([a-zA-Z0-9]+)';
    }

}
