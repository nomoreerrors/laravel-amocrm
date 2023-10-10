<?php

namespace Tests\Feature;

use App\Http\classes\MockClass;
use App\Http\classes\MyMock;
use App\Http\Middleware\WebhookMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use App\Jobs\CacheRequestsJob;
use Mockery\MockInterface;
use Resources\Services\WebhookLeadUpdateService;
use Tests\TestCase;
use Tests\TestObjects;

class JobTest extends TestCase
{

    public function test_something_can_be_mocked(): void
    {
        
        // $response = $this->post('/api/getupdates', (new TestObjects())->getWithValues())
        // ->assertStatus(200);

      

 
    }
}

