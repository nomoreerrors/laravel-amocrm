<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Jobs\Middleware\RedisRateLimitMiddleware;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class CacheRequestsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private $object;

    /** @var int retry times if job failed */
    public $tries = 50;


    /**
     * Create a new job instance.
     */
    public function __construct(string $object)
    {
        $this->object = $object;
    }

    
    /**
     * Execute the job.
     */
    public function handle(): void
    {   
        //смотрим Laracasts с утра
        //смотрим Laracasts с утра
        //смотрим Laracasts с утра
        


        Redis::throttle('key')->block(0)->allow(1)->every(3)->then(function () {
            info('Lock obtained...');



            route('test', ['lol']);

        }, function () {
            info('Im in failed block');
            
     
            return $this->release(3);
        });
    }

 
}
