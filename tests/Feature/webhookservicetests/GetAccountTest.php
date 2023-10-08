<?php

namespace Tests\Feature\webhookservicetests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\TestObjects;
use Resources\Services\WebhookLeadUpdateService;
use App\Http\classes\AmoCRMRepository;

class GetAccountTest extends TestCase
{
    private $data;
    private $testObjects;
    private $service;

    protected function setUp():void
    {
        parent::setUp();
        $this->testObjects = new TestObjects();
        $this->service = new WebhookLeadUpdateService(new AmoCRMRepository);
        
    }
  

    
    public function test_key_argument_not_set_return_account_array(): void
    {
        $object = $this->testObjects->getWithValues();
        $this->service->setdata($object);
        $this->assertArrayHasKey('subdomain', $this->service->getAccount());
    }



    public function test_key_argument_set_return_key(): void
    {
        $object = $this->testObjects->getWithValues();
        $this->service->setdata($object);
        $this->assertNotNull($this->service->getAccount('id'));
    }

    

    public function test_key_argument_not_exists_return_null(): void
    {
        $object = $this->testObjects->getWithValues();
        $this->service->setdata($object);
        $this->assertNull($this->service->getAccount('example'));
    }
    
}
