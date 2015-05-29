<?php namespace Coreplex\Meta\Managers;

use Illuminate\Support\Manager;
use Coreplex\Meta\Eloquent\Repository;

class Store extends Manager {

    public function getEloquentDriver()
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
        return $this->app['config']['meta.store'];
    }

    /**
     * Set the default authentication driver name.
     *
     * @param  string  $name
     * @return void
     */
    public function setDefaultDriver($name)
    {
        $this->app['config']['meta.store'] = $name;
    }

}