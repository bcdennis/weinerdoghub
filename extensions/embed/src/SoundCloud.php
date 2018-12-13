<?php
namespace Extensions\Embed;

use Exception;
use Smile\Core\Embed\BaseEmbedder;

class SoundCloud extends BaseEmbedder
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
        $data['type'] = 'soundcloud';

        $json = json_decode(file_get_contents('http://soundcloud.com/oembed?format=json&url='.$this->out[0].'&iframe=true'));
        $iframe = urldecode($json->html);

        if (preg_match('#\/tracks\/(.*?)&#', $iframe, $out)) {
            $data['media'] = $out[1];
        } else {
            throw new Exception('Not found!');
        }

        return $json->thumbnail_url;
    }

    /**
     * Regex needed for embedding detection
     *
     * @return mixed
     */
    public function regex()
    {
        return 'https?://soundcloud.com/([a-zA-Z0-9-_]+)/([a-zA-Z0-9-_]+)';
    }

}
