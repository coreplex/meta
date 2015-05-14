<?php namespace Coreplex\Meta\Contracts;

interface Container {

    /**
     * Add a meta item to the container
     * 
     * @param string|Coreplex\Meta\Contracts\Container $key
     * @param string|array $data
     * @return void
     */
    public function add($key, $data);

    /**
     * Retrieve the items from the container
     * 
     * @return array
     */
    public function items();

    /**
     * Overwrite the container with items from a given meta group
     * 
     * @param Coreplex\Contracts\Group $meta
     * @return void
     */
    public function set(Group $meta);

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