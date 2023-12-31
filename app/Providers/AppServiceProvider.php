<?php

namespace App\Providers;

use App\Models\AmoCRM\AmoConnectionInitialize;
use App\Models\AmoCRM\AmoCrmConnectionModel;
use App\Models\CrmConnectionInterface;
use App\Models\CrmConnectionModel;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Resources\Services\WebhookLeadUpdateService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
