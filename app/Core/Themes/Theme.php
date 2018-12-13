<?php

namespace Smile\Core\Themes;

class Theme
{
    protected $name;
    private $path;

    /**
     * Theme constructor.
     * @param $path
     * @param $name
     */
    public function __construct($path, $name)
    {
        $this->name = $name;
        $this->path = $path.'/'.$name;
    }

    /**
     * Get theme service provider name
     *
     * @return string
     */
    public function getServiceProvider()
    {
        return $this->getNamespace().'\ThemeServiceProvider';
    }

    /**
     * Get namespace for the current theme
     *
     * @return string
     */
    public function getNamespace()
    {
        return 'Themes\\'.studly_case($this->name);
    }

    /**
     * Get theme path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Get theme name
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

}
