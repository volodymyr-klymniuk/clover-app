<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $aliases = [];
    public array $serviceProviders = [
        EventServiceProvider::class
    ];

    /**
     * @return void Register any application services.
     */
    public function register()
    {
        $this->app->register(EventServiceProvider::class);
    }
}
