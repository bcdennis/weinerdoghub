<?php

use Extensions\Embed\DailyMotion;
use Extensions\Embed\Facebook;
use Extensions\Embed\SoundCloud;
use Extensions\Embed\Vimeo;
use Extensions\Embed\Vine;
use Extensions\Embed\Youtube;
use Smile\Core\Extensions\Extension;

class EmbedExtension extends Extension {

    public function register()
    {
        //
    }

    public function boot()
    {
        $manager = $this->app['Smile\Core\Contracts\Embed\ManagerContract'];
        $uploader = $this->app['Smile\Core\Contracts\Image\UploaderContract'];

        $manager->add(new Facebook($uploader));
        $manager->add(new Youtube($uploader));
        $manager->add(new Vimeo($uploader));
        $manager->add(new Vine($uploader));
        $manager->add(new SoundCloud($uploader));
        $manager->add(new DailyMotion($uploader));
    }

}
