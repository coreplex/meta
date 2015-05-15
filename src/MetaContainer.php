<?php namespace Coreplex\Meta;

use Coreplex\Meta\Contracts\Group;
use Coreplex\Meta\Contracts\Renderer;

class MetaContainer implements Contracts\Container {

    /**
     * The meta items.
     * 
     * @var array
     */
    protected $items = [];

    /**
     * The meta items.
     * 
     * @var Coreplex\Meta\Contracts\Renderer;
     */
    protected $renderer;

    /**
     * Make a new Container instance
     * 
     * @param Renderer $renderer
     * @return void
     */
    public function __construct(Renderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * Add a meta item to the container.
     * 
     * @param string|Coreplex\Meta\Contracts\Container $key
     * @param string|array $data
     * @return void
     */
    public function add($key, $data)
    {
        // If a group is passed, recursively add each item from the group and
        // exit the method
        if ($key instanceof Group) {
            foreach ($key->items() as $key => $data) {
                $this->add($key, $data);
            }
            return;
        }

        $this->items[$key] = $data;
    }

    /**
     * Retrieve the items from the container.
     * 
     * @return array
     */
    public function items()
    {
        return $this->items;
    }

    /**
     * Overwrite the container with items from a given meta group.
     * 
     * @param Coreplex\Contracts\Group $meta
     * @return void
     */
    public function set(Group $meta)
    {
        $this->items = $meta->meta();
    }

    /**
     * Render the items in the container.
     * 
     * @return string
     */
    public function render()
    {
        return $this->renderer->render($this);
    }

    /**
     * Render the items in the container.
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

}