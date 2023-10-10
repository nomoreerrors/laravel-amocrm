<?php

namespace Tests\Feature\Webhookservicetests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\TestObjects;
use Tests\Feature\webhookservicetests\BaseWebhookServiceTest;


class GetCustomFieldValueTest extends BaseWebhookServiceTest
{
     /**
     * id поля "Себестоимость" (value). 
     * @var int costPriceId
     */
    private string $primeCostFieldId = '2505835';
   

    /**
     * A basic feature test example.
     */
    public function test_object_has_value_field_return_value(): void
    {   
        $object = $this->testObjects->getWithValues();
        $this->service->setData($object);
        $this->assertEquals('string', gettype($this->service->getCustomFieldValue($this->primeCostFieldId)));
    }
 
 
}
 