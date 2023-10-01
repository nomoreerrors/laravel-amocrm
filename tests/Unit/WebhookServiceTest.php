<?php

namespace Tests\Unit;

use App\Http\classes\AmoCRMConfig;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Facades\Storage;
use Resources\Services\WebhookLeadUpdateService;

class WebhookServiceTest extends TestCase
{

     
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {   
        $c = new AmoCRMConfig();
        $this->assertIsArray($c);
    }
}
