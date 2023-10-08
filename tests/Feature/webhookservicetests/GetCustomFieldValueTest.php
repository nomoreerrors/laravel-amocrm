<?php

namespace Tests\Feature\Webhookservicetests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\TestObjects;
use Resources\Services\WebhookLeadUpdateService;
use App\Http\classes\AmoCRMRepository;

class GetCustomFieldValueTest extends TestCase
{
     /**
     * id поля "Себестоимость" (value). 
     * @var int costPriceId
     */
    private string $primeCostFieldId = '2505835';
    private $testObjects;
    private $service;

   
    protected function setUp():void
    {
        parent::setUp();
        $this->testObjects = new TestObjects();
        $this->service = new WebhookLeadUpdateService(new AmoCRMRepository);
    }


    /**
     * A basic feature test example.
     */
    public function test_object_has_value_field_return_value(): void
    {   
        $object = $this->testObjects->getWithValues();
        $this->service->setData($object);
        $this->assertEquals('string', gettype($this->service->getCustomFieldValue($this->primeCostFieldId)));
    }
 

    
 
    public function test_object_does_not_have_value_field_return_null(): void
    {   
        $object = $this->testObjects->getWithoutValues();
        $this->service->setData($object);
        $this->assertNull($this->service->getCustomFieldValue($this->primeCostFieldId));
    }
}
 