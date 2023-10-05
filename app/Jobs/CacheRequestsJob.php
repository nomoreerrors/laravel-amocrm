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
use App\Http\classes\AmoCRMConfig;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Resources\Services\WebhookLeadUpdateService;
use Illuminate\Support\Facades\Storage;

class CacheRequestsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private $request;

    /** @var int retry times if job failed */
    public $tries = 100;

    /**
     * id поля "Себестоимость" (value). 
     * @var int costPriceId
     */
    private $primeCostFieldId = 2505835;

    /**
     * id поля "Прибыль"
     * @var int $profitId
     */
    private $profitFieldId = 2505837;

    /**
     * Create a new job instance.
     */
    public function __construct(string $request)
    {
        $this->request = $request;
    }

    
    /**
     * Execute the job.
     */
    public function handle(): void
    {   

        Redis::throttle('key')->block(0)->allow(3)->every(1)->then(function () {
            info('Lock obtained...');

            $data = json_decode($this->request, true);
            $webHookHandler = new WebhookLeadUpdateService($data);
            // $webHookHandler->checkRequestLimitPerSecond();
       
        $webHookHandler->updateProfitField($this->primeCostFieldId, $this->profitFieldId);
             

        }, function () {
            info('Im in failed block');
            

            return $this->release(0);
        });
    }

 
}
