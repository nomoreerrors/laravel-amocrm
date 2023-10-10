<?php

namespace Tests\Feature\webhookservicetests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\TestObjects;
use App\Http\classes\AmoCRMRepository;
use Resources\Services\WebhookLeadUpdateService;

class BaseAmoCRMRepositoryTest extends TestCase
{
    protected $data;
    protected $testObjects;
    protected $service;
    protected $repository;


    protected function setUp():void
    {
        parent::setUp();
        $this->testObjects = new TestObjects();
        $this->service = new WebhookLeadUpdateService(new AmoCRMRepository);
        $this->repository = new AmoCRMRepository();
    }


    
}
