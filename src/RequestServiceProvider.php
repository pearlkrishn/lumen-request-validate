<?php

namespace Pearl\RequestValidate;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class RequestServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->commands([
            \Pearl\RequestValidate\Console\RequestMakeCommand::class
        ]);
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->app->afterResolving(RequestAbstract::class, function ($resolved) {
            $resolved->validateResolved();
        });

        $this->app->resolving(RequestAbstract::class, function ($request, $app) {
            $request = RequestAbstract::createFrom($app['request'], $request);
            $request->setContainer($app);
        });
    }
}
