<?php

declare(strict_types=1);

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Resources\Services\WebhookLeadUpdateService;

class CacheRequestsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private array $request;
    
    /** @var int $primeCostFieldId */
    private int $primeCostFieldId = 2505835;

    /**
     * id поля "Прибыль"
     * @var int $profitId
     */
    private int $profitFieldId = 2505837;

    private $service;


    /** @var int retry times if job failed */
    public $tries = 10;


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
    public function handle(WebhookLeadUpdateService $service): bool
    {   
            info('Job в очереди выполняется...');
            $service->setData($this->request);
            $service->updateProfitField($this->primeCostFieldId, $this->profitFieldId);
            return true;
            
    }


    
    

    
    public function middleware(): array
    {
        return [new WithoutOverlapping(json_encode($this->request))];
    }
}