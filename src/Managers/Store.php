<?php namespace Coreplex\Meta\Managers;

use Illuminate\Support\Manager;
use Coreplex\Meta\Eloquent\Repository as EloquentRepository;

class Store extends Manager {

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
        return $this->app['config']['drivers.store'];
    }

    /**
     * Set the default authentication driver name.
     *
     * @param  string  $name
     * @return void
     */
    public function setDefaultDriver($name)
    {
        $this->app['config']['drivers.store'] = $name;
    }

}