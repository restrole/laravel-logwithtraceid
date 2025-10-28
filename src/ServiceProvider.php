<?php

namespace Restrole\LaravelLogwithtraceid;



class ServiceProvider extends \Illuminate\Support\ServiceProvider
{

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/logwithtraceid.php' => config_path('logwithtraceid.php'),
        ], 'laravel-logwithtraceid');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/logwithtraceid.php', 'logwithtraceid');
    }
}
