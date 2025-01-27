<?php

namespace D4veR\Replicate\Providers;

use D4veR\Replicate\Replicate;
use D4veR\Replicate\Commands\Install;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class ReplicateServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Replicate::class, function () {
            return new Replicate(Config::get('services.replicate.api_token'));
        });
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Install::class,
            ]);
        }
    }
}