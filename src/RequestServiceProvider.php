<?php

namespace Pearl\RequestValidate;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class RequestServiceProvider extends ServiceProvider
{

    public function register()
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
    public function boot()
    {
        $this->app->resolving(RequestAbstract::class, function ($request, $app) {
            $this->initializeRequest($request, $app['request']);
        });
        
        $this->app->afterResolving(RequestAbstract::class, function ($resolved) {
            $resolved->validateResolved();
        });

    }

    /**
     * Initialize the form request with data from the given request.
     *
     * @param  \Pearl\RequestValidate\RequestAbstract  $form
     * @param  \Illuminate\Http\Request  $current
     * @return void
     */
    protected function initializeRequest(RequestAbstract $form, Request $current)
    {
        $files = $current->files->all();

        $files = is_array($files) ? array_filter($files) : $files;

        $form->initialize(
            $current->query->all(), $current->request->all(), $current->attributes->all(),
            $current->cookies->all(), $files, $current->server->all(), $current->getContent()
        );

        $form->setContainer($this->app);
    }
}
