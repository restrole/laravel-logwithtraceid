- [English](README.md)
- [中文](README_zh.md)

# Laravel Log Trace ID

This package adds trace IDs to all log messages in your Laravel application. It helps with debugging by providing a unique identifier that can be used to track requests across multiple services or log entries.

## Installation

You can install the package via Composer:

```BASH
composer require restrole/laravel-logwithtraceid
```

## Configuration

The package works out of the box with zero configuration. However, you can publish the config file if you want to customize the behavior:

```BASH
php artisan vendor:publish --tag=laravel-logwithtraceid
```

This will create a config/logwithtraceid.php file with the following options:

- middleware_groups: The middleware group to automatically register the middleware (default: api)
- header_name: The HTTP header name to use for the trace ID (default: X-Trace-ID)
- log_context_key: The key to use when adding the trace ID to the log context (default: trace_id)

```PHP
<?php

return [
    'middleware_groups' => ['api'],
    'header_name' => 'X-Trace-ID',
    'log_context_key' => 'trace_id',
];
```

### Automatic Middleware Registration

By default, the package automatically registers its middleware to the api middleware group. This means any request going through the API routes will automatically get a trace ID attached to all log messages.

### Manual Middleware Registration

If you prefer to manually register the middleware or need to use it in a different middleware group, you can do so by first disabling automatic registration in the config file:

```PHP
return [
    'middleware_group' => null, // Set to null to disable auto-registration
    // ... other config options
];
```

Then register the middleware manually in your app/Http/Kernel.php:

```PHP
protected $middlewareGroups = [
    'web' => [
        // ... other middleware
        \Restrole\LaravelLogWithTraceId\Middleware\AddTraceIdMiddleware::class,
    ],

    'api' => [
        // ... other middleware
        \Restrole\LaravelLogWithTraceId\Middleware\AddTraceIdMiddleware::class,
    ],
];
```

## Accessing the Trace ID

```PHP
$traceId = app('trace_id');
```

## Logging with Trace ID

Once installed, all your log messages will automatically include the trace ID:

```PHP
Log::info('User logged in');
// Output: [2025-01-01 12:00:00] local.INFO: User logged in {"trace_id":"abc123"}
```
