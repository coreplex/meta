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
        $this->registerRepository();
        $this->registerContainer();
        $this->registerRenderer();
        $this->registerTemplateRenderer();
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
            $defaultMeta = $app['coreplex.meta.repository']->defaultGroup();

            return new MetaContainer($app['coreplex.meta.renderer'], $defaultMeta);
        });

        $this->app->bind('Coreplex\Meta\Contracts\Container', function($app)
        {
            return $app['coreplex.meta'];
        });
    }

    /**
     * Register the meta renderer
     * 
     * @return void
     */
    public function registerRenderer()
    {
        $this->app->singleton('coreplex.meta.renderer', function($app)
        {
            return new MetaRenderer($app['config']['meta']['elements'], $app['config']['meta']['default'], $app['coreplex.meta.templateRenderer']);
        });

        $this->app->bind('Coreplex\Meta\Contracts\Renderer', function($app)
        {
            return $app['coreplex.meta'];
        });
    }

    /**
     * Register the template renderer
     * 
     * @return void
     */
    public function registerTemplateRenderer()
    {
        $this->app->singleton('coreplex.meta.templateRenderer', function($app)
        {
            return new TemplateRenderer;
        });

        $this->app->bind('Coreplex\Meta\Contracts\TemplateRenderer', function($app)
        {
            return $app['coreplex.meta.templateRenderer'];
        });
    }

    /**
     * Register the meta repository
     * 
     * @return void
     */
    public function registerRepository()
    {
        $this->app->singleton('coreplex.meta.repository', function($app)
        {
            return new Eloquent\Repository;
        });

        $this->app->bind('Coreplex\Meta\Contracts\Repository', function($app)
        {
            return $app['coreplex.meta.repository'];
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('coreplex.meta.template', 'coreplex.meta.renderer', 'coreplex.meta.templateRenderer', 'coreplex.meta.repository');
    }


}