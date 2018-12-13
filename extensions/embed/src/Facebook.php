<?php
namespace Extensions\Embed;

use Smile\Core\Embed\BaseEmbedder;

class Facebook extends BaseEmbedder
{

    /**
     * Regex for embedder detection
     *
     * @return string
     */
    public function regex()
    {
        $type1 = 'https:\/\/www.facebook.com\/.*?\/videos\/([0-9]+)';
        $type2 = 'https:\/\/www.facebook.com\/video\.php\?v=([0-9]+)';

        return $type1.'|'.$type2;
    }

    /**
     * Embed the video
     *
     * @param array $data
     * @return string
     * @throws \Exception
     */
    protected function embed(array& $data)
    {
        $data['type'] = 'facebook';
        $data['media'] = $this->out[0];

        $id = isset($this->out[2]) ? $this->out[2] : $this->out[1];
        $image = file_get_contents('https://graph.facebook.com/'.$id.'/picture');

        if (stripos($image, 'error') !== false) {
            throw new \Exception('Not found');
        }

        return $image;
    }

}
