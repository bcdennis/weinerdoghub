<?php namespace Smile\Events\Post;

use Illuminate\Queue\SerializesModels;
use Intervention\Image\Image;
use Smile\Events\Event;

class BeforeMediaUpload extends Event
{

    use SerializesModels;
    /**
     * @var Image
     */
    public $featured;
    /**
     * @var Image
     */
    public $thumbnail;
    /**
     * @var Image
     */
    public $media;

    /**
     * Create a new event instance.
     *
     * @param Image $featured
     * @param Image $thumbnail
     * @param Image $media
     */
    public function __construct(Image $featured, Image $thumbnail, Image $media)
    {
        $this->featured = $featured;
        $this->thumbnail = $thumbnail;
        $this->media = $media;
    }

}
