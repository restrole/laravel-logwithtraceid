<?php

namespace Restrole\LaravelLogWithTraceId;

use Restrole\LaravelLogWithTraceId\Middleware\AddTraceIdMiddleware;




class ServiceProvider extends \Illuminate\Support\ServiceProvider
{

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/logwithtraceid.php' => config_path('logwithtraceid.php'),
        ], 'laravel-logwithtraceid');

        if (is_array(config('logwithtraceid.middleware_groups'))) {
            foreach (config('logwithtraceid.middleware_groups') as $group) {
                $this->app['router']->pushMiddlewareToGroup($group, AddTraceIdMiddleware::class);
            }
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/logwithtraceid.php', 'logwithtraceid');
    }
}
