<?php
namespace Extensions\Embed;

use Smile\Core\Embed\BaseEmbedder;

class Vimeo extends BaseEmbedder
{

    /**
     * Embed the video
     *
     * @param array $data
     * @return mixed|void
     */
    protected function embed(array& $data)
    {
        $data['type'] = 'vimeo';
        $data['media'] = $this->out[1];
        $api = unserialize(file_get_contents('http://vimeo.com/api/v2/video/'.$data['media'].'.php'));
        $url = $api[0]['thumbnail_large'];

        return $url;
    }

    /**
     * Regex needed for embedding detection
     *
     * @return mixed
     */
    public function regex()
    {
        return 'https?://(?:www\.)?vimeo\.com/(?:\w*/)*(([a-z]{0,2}-)?\d+)';
    }

}
