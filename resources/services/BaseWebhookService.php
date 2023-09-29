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
     * Учет и ограничение общего количества запросов всех пользователей аккаунта
     */
    public function setGeneralRequestCount(): void
    {
       $lastRequestTime = json_decode(Storage::get('lastRequestTime.txt'), true);

            $lastRequestTime['users_request_count'][] = time();
            $c = $lastRequestTime['users_request_count'];

           
            

            if(count($c) < 7) { 
                Storage::put('lastRequestTime.txt', json_encode($lastRequestTime));
            }

            if(count($c) >= 7 && $c[6] - $c[0] < 10) {
                Log::info('Слишком частые запросы к API от пользователей аккаунта');
                dd($c);
                response('ok');
                die;
            } 
            dd('here');
            // elseif(count($c) >= 7) {
            //     $lastRequestTime['users_request_count'] = [];
            //     $lastRequestTime['users_request_count'][] = time();
            //     Storage::put('lastRequestTime.txt', json_encode($lastRequestTime));
            // }
    
    }


    /**
     * Остановка цикла и ограничение кол-ва запросов к API
     */
    public function checkUserRequestLimit(?array $lastRequestTime, string $accountId)
    {
         if($lastRequestTime && 
           array_key_exists($accountId, $lastRequestTime) &&
           $lastRequestTime[$accountId] >= time()) {
                Log::info('Остановка цикла запросов'
                                            . $lastRequestTime[$accountId] .' ' . time());
                response('ok');
                die;
        }
  

    }







}