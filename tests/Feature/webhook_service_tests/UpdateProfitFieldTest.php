<?php

declare(strict_types=1);

namespace Tests\Feature\webhookservicetests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Feature\webhookservicetests\BaseWebhookServiceTest;

class UpdateProfitFieldTest extends BaseWebhookServiceTest
{
     /** id поля "Cебестоимость" */
    private int $primeCostFieldId = 2505835;

    
    /** id поля "Прибыль" */
    private int $profitFieldId = 2505837;



    public function test_object_has_all_needed_fields_return_true(): void
    {
       $this->service->setData($this->testObjects->getWithValues());
       $this->assertNotFalse($this->service->updateProfitField($this->primeCostFieldId, $this->profitFieldId));

    }


    public function test_object_has_no_any_field_return_false(): void
    {
       $this->service->setData($this->testObjects->getWithOutValues());
       $this->assertFalse($this->service->updateProfitField($this->primeCostFieldId, $this->profitFieldId));

    }
}
