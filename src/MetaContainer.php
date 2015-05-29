<?php namespace Coreplex\Meta;

use Coreplex\Meta\Contracts\Group;
use Coreplex\Meta\Contracts\Repository;
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
     * The meta items.
     * 
     * @var Coreplex\Meta\Contracts\StoreManager;
     */
    protected $storeManager;

    /**
     * Make a new Container instance
     * 
     * @param Renderer $renderer
     * @return void
     */
    public function __construct(Renderer $renderer, Repository $store)
    {
        $this->renderer = $renderer;

        $this->store = $store;

        if ( ! is_null($default = $this->store->defaultGroup())) {
            $this->set($default);
        }
    }

    /**
     * Add a meta item to the container.
     * 
     * @param string|Coreplex\Meta\Contracts\Group $key
     * @param string|array $data
     * @return void
     */
    public function add($key, $data = false)
    {
        // If a group is passed, recursively add each item from the group and
        // exit the method
        if ($key instanceof Group) {
            foreach ($key->meta() as $key => $data) {
                $this->add($key, $data);
            }
            return;
        } elseif ( ! $data) {
            $this->add($this->store->find($key));
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
    public function set($meta)
    {
        if ($meta instanceof Group) {
            $this->items = $meta->meta();
        } else {
            $this->store->find($meta);
        }
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