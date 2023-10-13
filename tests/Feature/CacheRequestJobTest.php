<?php

namespace Tests\Feature;

use App\Http\classes\AmoCRMRepository;
use App\Http\classes\MockClass;
use App\Http\classes\MyMock;
use App\Http\Middleware\WebhookMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use App\Jobs\CacheRequestsJob;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Resources\Services\WebhookLeadUpdateService;
use Tests\TestCase;
use Tests\TestObjects;
use Illuminate\Support\Facades\Queue;


class CacheRequestJobTest extends TestCase
{


   private array $object;
   private CacheRequestsJob $job;
   private WebhookLeadUpdateService $service;


    protected function setUp():void
    {
       parent::setUp();
       $this->object = (new TestObjects())->getWithValues();
       $this->job = new CacheRequestsJob($this->object);
       $this->service = new WebhookLeadUpdateService(new AmoCRMRepository());
       
    }


   public function test_handle_method_returns_true()
   {
      $this->assertTrue($this->job->handle($this->service));
   }

   

    public function test_request_job_can_be_shipped(): void
    {
    
      Queue::fake();
      $this->post('/api/getupdates', $this->object);
      Queue::assertPushed(CacheRequestsJob::class);
    }
}

