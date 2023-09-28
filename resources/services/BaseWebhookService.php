<?php

namespace Resources\Services;

use Illuminate\Support\Facades\Log;

/**
 * Обработка полученных данных 
 */
class BaseWebhookService
{
    /**
     * Остановка цикла запросов с webhook
     */
    public function checkRequestLimit(array $lastRequestTime, string $accountId)
    {
         if($lastRequestTime && 
           array_key_exists($accountId, $lastRequestTime) &&
           $lastRequestTime[$accountId] >= time()) {
                Log::info('Остановка цикла запросов. Слишком частые попытки обновить сделку '
                                            . $lastRequestTime[$accountId] .' ' . time());
                response('ok');
                die;
        }
  

    }







}