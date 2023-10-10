<?php

declare(strict_types=1);

namespace Tests\Feature\webhookservicetests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Feature\webhookservicetests\BaseWebhookServiceTest;

class CheckStateTest extends BaseWebhookServiceTest
{
     private string $state = 'ovjwoefoiwef23090293fohbodhglnm';


    public function test_request_with_wrong_state_unable_to_access(): void
    {
      $object = $this->testObjects->getWithWrongState();
      $this->service->setData($object);
      $this->assertFalse($this->service->checkState($this->state, $object['state']));

    }


    
}
