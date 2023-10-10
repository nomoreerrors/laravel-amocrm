<?php

namespace Tests\Feature\webhookservicetests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\webhookservicetests\BaseWebhookServiceTest;

class GetAccountTest extends BaseWebhookServiceTest
{
    
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
