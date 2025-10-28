<?php

namespace Restrole\LaravelLogWithTraceId\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AddTraceIdMiddleware
{
    public function handle($request, Closure $next)
    {
        $header_name = config('logwithtraceid.header_name');
        $log_context_key = config('logwithtraceid.log_context_key');

        // 优先从请求头获取 trace_id（如 X-Trace-Id），否则生成新的
        $traceId = $request->header($header_name) ?? Str::uuid()->toString();

        // 将 trace_id 绑定到日志上下文
        Log::withContext([$log_context_key => $traceId]);
        // 存入容器，供日志和异常使用
        App::instance($log_context_key, $traceId);

        // 将 trace_id 写入响应头，便于前端追踪
        $response = $next($request);
        $response->headers->set($header_name, $traceId);

        return $response;
    }
}
