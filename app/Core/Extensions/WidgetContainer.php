<?php

namespace Smile\Core\Extensions;

class WidgetContainer
{

    /**
     * Views container
     *
     * @var array
     */
    protected $views = [];

    public function __construct()
    {

    }

    /**
     * Register a new view or string into a section
     *
     * @param $section
     * @param $view
     * @param int $priority
     */
    public function register($section, $view, $priority = 0)
    {
        $this->views[$section][$priority][] = $view;

    }

    /**
     * Render a section and return the view hooks
     *
     * @param $section
     * @param array $data
     * @return string
     */
    public function render($section, array $data = [])
    {
        if ( ! isset($this->views[$section])) {
            return '';
        }

        $response = '';

        foreach ($this->views[$section] as $priority => $views) {
            foreach ($views as $view) {
                $view = call_user_func_array($view, $data);
                $response .= is_object($view) ? $view->render() : $view;
            }
        }

        return $response;
    }

}
