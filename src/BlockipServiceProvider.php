<?php namespace Olssonm\Blockip;

use Illuminate\Support\ServiceProvider;

class BlockipServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(\Illuminate\Routing\Router $router)
    {
        // Publishing of configuration
        $this->publishes([
            __DIR__ . '/config.php' => config_path('blockip.php'),
        ]);

        // Load default view/s
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'blockip');

        // Register middleware
        $router->middleware('blockip', 'Olssonm\Blockip\Http\Middleware\BlockipMiddleware');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        // If the user hasn't set their own config, load default
        $this->mergeConfigFrom(
            __DIR__ . '/config.php', 'blockip'
        );
    }
}
