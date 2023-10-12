<?php

namespace Tests\Feature\webhook_service_tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Feature\webhookservicetests\BaseWebhookServiceTest;

class GetLeadIdTest extends BaseWebHookServiceTest
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
       $object = $this->testObjects->getWithValues();
       $this->service->setData($object);

       $this->assertIsInt($this->service->getLeadId());
    

    
}
}