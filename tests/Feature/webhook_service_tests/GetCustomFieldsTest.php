<?php

namespace Tests\Feature\webhookservicetests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\TestObjects;
use Resources\Services\WebhookLeadUpdateService;
use App\Http\classes\AmoCRMRepository;
use Tests\Feature\webhookservicetests\BaseWebhookServiceTest;

class GetCustomFieldsTest extends BaseWebhookServiceTest
{

    public function test_custom_fields_exists_return_array(): void
    {
        $object = $this->testObjects->getWithCustomFields();
        $this->service->setData($object);
        $this->assertIsArray($this->service->getCustomFields());
    }
}
