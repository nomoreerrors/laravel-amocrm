<?php

namespace Tests\Feature\webhookservicetests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Feature\webhookservicetests\BaseWebhookServiceTest;


class GetKeyFromLeadTest extends BaseWebhookServiceTest
{

    public function test_key_exists_return_key(): void
    {
        $object = $this->testObjects->getWithValues();
        $this->service->setData($object);
        $this->assertNotNull($this->service->getKeyFromLead('name'));
    }

   



}
