<?php

namespace HaiPG\LaravelCore;

use Illuminate\Support\ServiceProvider;
use HaiPG\LaravelCore\Commands\MakeEnum;
use HaiPG\LaravelCore\Commands\MakeResponse;
use HaiPG\LaravelCore\Commands\MakeRepository;
use HaiPG\LaravelCore\Commands\MakeService;
use HaiPG\LaravelCore\Commands\MakeFilter;

class LaravelCoreServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeRepository::class,
                MakeService::class,
                MakeFilter::class,
                MakeResponse::class,
                MakeEnum::class,
            ]);
        }
    }
}
