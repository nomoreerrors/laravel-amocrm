<?php

namespace App\Jobs\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;
 
class RedisRateLimitMiddleware
{
    /**
     * Process the queued job.
     *
     * @param  \Closure(object): void  $next
     */
    public function handle(object $job, Closure $next): void
    {
        
        Redis::throttle('key')
                ->block(0)->allow(1)->every(5)
                ->then(function () use ($job, $next) {
                    // Lock obtained...
                    Log::info('here');
                    $next($job);
                }, function () use ($job) {
                    // Could not obtain lock...
 
                    $job->release(5);
                });
    }
}