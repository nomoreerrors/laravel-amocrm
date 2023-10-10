<?php

declare(strict_types=1);

namespace Tests\Feature\webhookservicetests;

use AmoCRM\Collections\CustomFieldsValuesCollection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\Feature\webhookservicetests\BaseAmoCRMRepositoryTest;


class CreateCustomFieldTextValueTest extends BaseAmoCRMRepositoryTest
{
    
    private int $fieldId = 2505835;
    private string $value = '500';


    public function test_make_sure_all_fields_set_correctly(): void
    {   
        $c = $this->repository->CreateCustomFieldsTextValue($this->fieldId, $this->value);
        $a = $c->toArray();

       $this->assertTrue(Arr::get($a, '0.field_id') && Arr::get($a, '0.values') && Arr::get($a, '0.values.0.value'));
    
    }
}
