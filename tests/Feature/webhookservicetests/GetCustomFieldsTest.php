<?php

namespace Tests\Feature\webhookservicetests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\TestObjects;
use Resources\Services\WebhookLeadUpdateService;
use App\Http\classes\AmoCRMRepository;

class GetCustomFieldsTest extends TestCase
{
    private $testObjects;
    private $service;



    protected function setUp():void
    {
        parent::setUp();
        $this->testObjects = new TestObjects();
        $this->service = new WebhookLeadUpdateService(new AmoCRMRepository);
    }


    public function test_custom_fields_exists_return_array(): void
    {
        $object = $this->testObjects->getWithCustomFields();
        $this->service->setData($object);
        $this->assertIsArray($this->service->getCustomFields());
    }


    public function test_custom_fields_not_exists_return_null(): void
    {
        $object = $this->testObjects->getWithoutCustomFields();
        $this->service->setData($object);
        $this->assertNull($this->service->getCustomFields());
    }

     




}
