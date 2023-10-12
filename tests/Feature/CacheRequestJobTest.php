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
use Resources\Services\WebhookLeadUpdateService;
use Tests\TestCase;
use Tests\TestObjects;

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


   public function test_return_true_after_job_is_done()
   {
      $this->assertTrue($this->job->handle($this->service));
   }

   

    public function test_withoutoverlapping_method_exists_and_argument_type_is_string(): void
    {
       $this->assertIsArray($this->job->withoutOverLapping('some_string'));
       

 
    }
}

