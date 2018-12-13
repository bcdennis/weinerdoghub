<?php
namespace Extensions\Embed;

use Smile\Core\Embed\BaseEmbedder;

class Youtube extends BaseEmbedder
{

    /**
     * Embed the video
     *
     * @param array $data
     * @return mixed|void
     */
    protected function embed(array& $data)
    {
    	$id = isset($this->out[2]) ? $this->out[2] : $this->out[1];
        $data['type'] = 'youtube';
        $data['media'] = $id;

        return sprintf('http://img.youtube.com/vi/%s/0.jpg', $id);
    }

    /**
     * Regex needed for embedding detection
     *
     * @return mixed
     */
    public function regex()
    {
    	$type1 = 'https:\/\/www.youtube.com\/watch\?v=([a-zA-Z0-9-_]+)';
    	$type2 = 'https:\/\/youtu.be\/([a-zA-Z0-9-_]+)(?:\?t=t=.*)?';

        return $type1.'|'.$type2;
    }

}
