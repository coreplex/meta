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

        // Merge the default config with the application config
        $this->mergeConfigFrom(__DIR__.'/../config/meta.php', 'meta');
        $this->mergeConfigFrom(__DIR__.'/../config/drivers.php', 'drivers');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerContainer();
        $this->registerRenderer();
    }

    /**
     * Register the meta container
     * 
     * @return void
     */
    public function registerContainer()
    {
        $this->app->singleton('coreplex.meta', function($app)
        {
            return new MetaContainer($app['coreplex.meta.renderer']);
        });

        $this->app->bind('Coreplex\Meta\Contracts\Container', function($app)
        {
            return $app['coreplex.meta'];
        });
    }

    /**
     * Register the meta container
     * 
     * @return void
     */
    public function registerRenderer()
    {
        $this->app->singleton('coreplex.meta.renderer', function($app)
        {
            return new MetaRenderer($app['config']['meta']['elements'], $app['config']['meta']['default']);
        });

        $this->app->bind('Coreplex\Meta\Contracts\Renderer', function($app)
        {
            return $app['coreplex.meta'];
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('coreplex.meta.renderer');
    }


}