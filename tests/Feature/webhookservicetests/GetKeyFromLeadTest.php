<?php

namespace Tests\Feature\webhookservicetests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\TestObjects;
use Resources\Services\WebhookLeadUpdateService;
use App\Http\classes\AmoCRMRepository;

class GetKeyFromLeadTest extends TestCase
{
    private $testObjects;
    private $service;



    protected function setUp():void
    {
        parent::setUp();
        $this->testObjects = new TestObjects();
        $this->service = new WebhookLeadUpdateService(new AmoCRMRepository);
    }


    public function test_key_exists_return_key(): void
    {
        $object = $this->testObjects->getWithValues();
        $this->service->setData($object);
        $this->assertNotNull($this->service->getKeyFromLead('name'));
    }

    public function test_key_not_exists_return_null(): void
    {
        $object = $this->testObjects->getWithValues();
        $this->service->setData($object);
        $this->assertNull($this->service->getKeyFromLead('example'));
    }




}
