<?php

namespace Smile\Core\Embed;

use Smile\Core\Contracts\Image\UploaderContract;

abstract class BaseEmbedder
{

    /**
     * Data from url regex matching
     *
     * @var array
     */
    protected $out;

    /**
     * @var UploaderContract
     */
    private $imageUpload;

    /**
     * @param UploaderContract $imageUpload
     */
    public function __construct(UploaderContract $imageUpload)
    {
        $this->imageUpload = $imageUpload;
    }

    /**
     * Check if link is embeddable
     *
     * @param $url
     * @return int
     */
    public function canEmbed($url)
    {
        return preg_match('#' . $this->regex() . '#', $url, $this->out);
    }

    /**
     * Regex needed for embedding detection
     *
     * @return mixed
     */
    public abstract function regex();

    /**
     * Process video embed
     *
     * @param array $data
     * @return array
     */
    public function process(array & $data)
    {
        $url = $this->embed($data);

        $data['featured'] = $this->imageUpload->uploadSmallImage($data, $url);

        return $data;
    }

    /**
     * Find thumbnail for the video
     *
     * @param array $data
     * @return mixed
     */
    protected abstract function embed(array & $data);

}
