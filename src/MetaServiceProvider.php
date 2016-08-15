<?php

namespace Coreplex\Meta;

use Illuminate\Support\ServiceProvider;

class MetaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // Set the files to publish
        $this->publishes([
            __DIR__ . '/../config/meta.php' => config_path('meta.php'),
            __DIR__ . '/../config/drivers.php' => config_path('drivers.php'),
            __DIR__ . '/../database/migrations/' => base_path('database/migrations')
        ]);

        // Merge the default config with the application config
        $this->mergeConfigFrom(__DIR__ . '/../config/meta.php', 'meta');
        $this->mergeConfigFrom(__DIR__ . '/../config/drivers.php', 'drivers');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerStore();
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
        $this->app->singleton('coreplex.meta', function ($app) {
            return new MetaContainer($app['coreplex.meta.renderer'], $app['coreplex.meta.store.driver']);
        });

        $this->app->bind('Coreplex\Meta\Contracts\Container', function ($app) {
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
        $this->app->singleton('coreplex.meta.renderer', function ($app) {
            return new MetaRenderer($app['config']['meta']['elements'], $app['config']['meta']['default'],
                $app['coreplex.meta.templateRenderer']);
        });

        $this->app->bind('Coreplex\Meta\Contracts\Renderer', function ($app) {
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
        $this->app->singleton('coreplex.meta.templateRenderer', function ($app) {
            $templates = $app['config']['meta']['elements'];

            return new TemplateRenderer($templates);
        });

        $this->app->bind('Coreplex\Meta\Contracts\TemplateRenderer', function ($app) {
            return $app['coreplex.meta.templateRenderer'];
        });
    }

    /**
     * Register the meta store manager and driver
     *
     * @return void
     */
    protected function registerStore()
    {
        $this->app->singleton('coreplex.meta.store', function ($app) {
            return new Managers\Store($app);
        });

        $this->app->singleton('coreplex.meta.store.driver', function ($app) {
            return $app['coreplex.meta.store']->driver();
        });

        $this->app->bind('Coreplex\Meta\Contracts\Repository', function ($app) {
            return $app['coreplex.meta.store.driver'];
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array(
            'coreplex.meta.template',
            'coreplex.meta.renderer',
            'coreplex.meta.templateRenderer',
            'coreplex.meta.store',
            'coreplex.meta.store.driver'
        );
    }
}