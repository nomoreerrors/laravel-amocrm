<?php

namespace Tests\Feature\amocrm_repository_tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\webhookservicetests\BaseAmoCRMRepositoryTest;
use Tests\TestCase;
use Tests\TestObjects;
use App\Http\classes\AmoCRMRepository;
use Resources\Services\WebhookLeadUpdateService;

class AmoCRMControllerTest extends TestCase
{
    protected $data;
    protected $testObjects;
    protected $service;


    protected function setUp():void
    {
        parent::setUp();
        $this->testObjects = new TestObjects();
        $this->service = new WebhookLeadUpdateService(new AmoCRMRepository);
    }


    /**
     * A basic feature test example.
     */
    public function test_get_updates_all_fields_exist_return_status_200(): void
    {
        $response = $this->post('/api/getupdates', $this->testObjects->getWithValues());
        $response->assertStatus(200);
    }


    public function test_get_updates_some_field_not_set_return_status_100(): void
    {
        $response = $this->post('/api/getupdates', $this->testObjects->getWithoutValues());
        $response->assertStatus(100);
    }



    public function test_get_updates_wrong_state_return_status_403(): void
    {
        $response = $this->post('/api/getupdates', $this->testObjects->getWithWrongState());
        $response->assertStatus(403);
    }
}
