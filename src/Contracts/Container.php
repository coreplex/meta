<?php namespace Coreplex\Meta\Contracts;

interface Container {

    /**
     * Add a meta item to the container
     * 
     * @param string|Coreplex\Meta\Contracts\Group $key
     * @param string|array $data
     * @return void
     */
    public function add($key, $data = false);

    /**
     * Retrieve the items from the container
     * 
     * @return array
     */
    public function items();

    /**
     * Overwrite the container with items from a given meta group, or find one
     * by it's identifier
     * 
     * @param Coreplex\Contracts\Group|string $meta
     * @return void
     */
    public function set($meta);

    /**
     * Empty the items from the container.
     * 
     * @return void
     */
    public function flush();

    /**
     * Render the items in the container
     * 
     * @return string
     */
    public function render();

    /**
     * Render the items in the container
     * 
     * @return string
     */
    public function __toString();

}