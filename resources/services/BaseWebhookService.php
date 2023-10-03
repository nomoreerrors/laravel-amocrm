<?php

namespace Resources\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Обработка полученных данных 
 */
class BaseWebhookService
{

    /**
     * Учет и ограничение общего количества запросов в секунду всех пользователей аккаунта
     */
    public function checkRequestLimitPerSecond(): void
    {
        $lastRequestTime = json_decode(Storage::get('lastRequestTime.txt'), true);
        $lastRequestTime['users_request_count'][] = time();
        Storage::put('lastRequestTime.txt', json_encode($lastRequestTime));
        Log::info('3 requestpersecond' , [__CLASS__]);

            $c = $lastRequestTime['users_request_count'];
            $lastElementIndex = array_search(end($c), $c);
           
            

            if(count($c) >= 7 && $c[$lastElementIndex] - $c[$lastElementIndex - 6] < 2) {
                Log::info('Слишком частые запросы к API от пользователей аккаунта');
                response('ok');
                die;
            } 
            
           
            if(count($c) >= 100) {
                $lastRequestTime['users_request_count'] = [];
                $lastRequestTime['users_request_count'][] = time();
                Storage::put('lastRequestTime.txt', json_encode($lastRequestTime));
            }
    
    }


    /**
     * Остановка цикла и ограничение кол-ва запросов к API
     */
    public function preventRequestInfiniteLoop(?array $lastRequestTime, string $accountId, string $lastLeadId)
    {
         

         if($lastRequestTime && 
           array_key_exists($accountId, $lastRequestTime) &&
           array_key_exists('last_lead_id', $lastRequestTime[$accountId]) &&
           $lastRequestTime[$accountId]['last_lead_id'] === $lastLeadId &&
           $lastRequestTime[$accountId]['last_request_time'] >= time()) {

                Log::info('Остановка цикла запросов. ',
                ['Время предыдущего запроса: '. $lastRequestTime[$accountId]['last_request_time'] .' Новый запрос: ' . time()
                . __CLASS__ . __LINE__]);
                response('ok');
                die;
         }

         $lastRequestTime[$accountId]['last_request_time'] = time() + 1;
         $lastRequestTime[$accountId]['last_lead_id'] = $lastLeadId;
         Storage::put('lastRequestTime.txt', json_encode($lastRequestTime));

    }







}