<?php

namespace Cryptolib\CryptoCore;


use Cryptolib\CryptoCore\Middleware\XApiVersionMiddleware;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class CryptoCoreServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/crypto.php', 'crypto');
        $this->publishes([
            __DIR__ . '/config' => base_path('config'),
        ]);
        $this->registerRoutes();
        $this->loadMigrationsFrom(__DIR__ . '/migrations');

        /*  $kernel = $this->app->make(Kernel::class);
          $kernel->pushMiddleware(XApiVersionMiddleware::class);*/

        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('x-api', XApiVersionMiddleware::class);
    }


    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/routes.php');
        });
    }

    protected function routeConfiguration()
    {
        return [
            'prefix' => config('crypto.prefix'),
            'middleware' => config('crypto.middleware'),
        ];
    }
}
