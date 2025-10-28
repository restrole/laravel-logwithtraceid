- [English](README.md)
- [中文](README_zh.md)

# Laravel Log Trace ID

该包为您的 Laravel 应用程序中的所有日志消息添加追踪 ID。通过提供可用于跨多个服务或日志条目跟踪请求的唯一标识符，帮助调试。

## 安装

您可以通过 Composer 安装该包：

```BASH
composer require restrole/laravel-logwithtraceid
```

## 配置

该软件包开箱即用，无需任何配置。您也可以通过发布配置文件进行个性化配置：

```BASH
php artisan vendor:publish --tag=laravel-logwithtraceid
```

该命令创建一个具有以下选项的 config/logwithtraceid.php 文件：

- middleware_groups: 开启自动注册中间件（默认值：api，web）
- header_name: 用于 trace_id 的 HTTP 报文头（默认值：X-Trace-ID）
- log_context_key: 将 trace_id 添加到日志上下文时使用的键（默认值：trace_id）

```PHP
<?php

return [
    'middleware_groups' => ['api'],
    'header_name' => 'X-Trace-ID',
    'log_context_key' => 'trace_id',
];
```

### 自动注册

默认情况下，该包会自动将其中间件注册到 api 中间件组。这意味着任何经过 API 路由的请求都会自动获得一个附加到所有日志消息的跟踪 ID。

### 手动注册

如果您希望手动注册中间件或需要在不同的中间件组中使用，您可以首先在配置文件中禁用自动注册：

```PHP
return [
    'middleware_group' => null, // Set to null to disable auto-registration
    // ... other config options
];
```

然后在 app/Http/Kernel.php 中手动注册中间件：

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

## 获取 Trace ID

```PHP
$traceId = app('trace_id');
```

## 使用 TRACE ID 进行记录

安装后，所有日志消息将自动包含跟踪 ID：

```PHP
Log::info('User logged in');
// Output: [2025-01-01 12:00:00] local.INFO: User logged in {"trace_id":"abc123"}
```
