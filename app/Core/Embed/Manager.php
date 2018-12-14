<?php

namespace Smile\Core\Embed;

use Smile\Core\Contracts\Embed\ManagerContract;

class Manager implements ManagerContract
{
    /**
     * List of available embedders
     *
     * @var BaseEmbedder[]
     */
    protected $embedders = [];

    /**
     * Push a new embedder to the list
     *
     * @param $embedder
     */
    public function add(BaseEmbedder $embedder)
    {
        $this->embedders[get_class($embedder)] = $embedder;
    }

    /**
     * Remove embedding provider
     *
     * @param $name
     */
    public function remove($name)
    {
        unset($this->embedders[$name]);
    }

    /**
     * All the embedders
     *
     * @return BaseEmbedder[]
     */
    public function all()
    {
        return $this->embedders;
    }

    /**
     * Check if url is embeddable
     *
     * @param $url
     * @return int
     */
    public function isEmbeddable($url)
    {
        if (!count($this->embedders)) {
            return false;
        }

        $regex = [];

        foreach ($this->embedders as $embedder) {
            $regex[] = $embedder->regex();
        }

        $regex = implode('|', $regex);

        return preg_match('#' . $regex . '#', $url);
    }

}
