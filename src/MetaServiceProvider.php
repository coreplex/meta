<?php namespace Coreplex\Meta; 

use Illuminate\Support\ServiceProvider;

class MetaServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // Set the files to publish
        $this->publishes([
            __DIR__.'/../config/meta.php' => config_path('meta.php'),
            __DIR__.'/../config/drivers.php' => config_path('drivers.php'),
            __DIR__.'/../database/migrations/' => base_path('database/migrations')
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/meta.php', 'meta');
    }

}