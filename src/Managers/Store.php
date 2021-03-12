<?php

namespace Coreplex\Meta\Managers;

use Illuminate\Support\Manager;
use Coreplex\Meta\Eloquent\Repository as EloquentRepository;

class Store extends Manager
{
    public function createEloquentDriver()
    {
        return new EloquentRepository;
    }

    /**
     * Get the default authentication driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        $container = ! empty($this->container) ? $this->container : $this->app;

        return $container['config']['drivers.store'];
    }

    /**
     * Set the default authentication driver name.
     *
     * @param  string $name
     * @return void
     */
    public function setDefaultDriver($name)
    {
        $container = ! empty($this->container) ? $this->container : $this->app;

        $container['config']['drivers.store'] = $name;
    }
}
