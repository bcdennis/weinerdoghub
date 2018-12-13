<?php
namespace Smile\Core\Contracts\Embed;

use Smile\Core\Embed\BaseEmbedder;

interface ManagerContract
{
    /**
     * Check if an url is embeddable
     *
     * @param $url
     * @return mixed
     */
    public function isEmbeddable($url);

    /**
     * Load a new embedder into the manager
     *
     * @param BaseEmbedder $embedder
     */
    public function add(BaseEmbedder $embedder);

    /**
     * Remove an embedder from the manager
     *
     * @param $name
     */
    public function remove($name);

    /**
     * Get all embedders
     *
     * @return BaseEmbedder[]
     */
    public function all();

}
