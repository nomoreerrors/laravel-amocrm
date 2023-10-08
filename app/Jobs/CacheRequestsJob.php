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
    public $tries = 1;

    /**
     * id поля "Себестоимость" (value). 
     * @var int costPriceId
     */
    private string $primeCostFieldId = '2505835';

    /**
     * id поля "Прибыль"
     * @var int $profitId
     */
    private string $profitFieldId = '2505837';


    private $service;

    /**
     * Create a new job instance.
     */
    public function __construct(array $request)
    {
        $this->request = $request;
    }

    
    /**
     * Execute the job.
     */
    public function handle(WebhookLeadUpdateService $service): void
    {   

        Redis::throttle('key')->block(0)->allow(3)->every(1)->then(function () use ($service){
            info('Job в очереди выполняется...');

            $service->setData($this->request);
            $service->updateProfitField($this->primeCostFieldId, $this->profitFieldId);
             

        }, function () {
            info('Job in failed block');
            

            return $this->release(0);
        });
    }

 
}
