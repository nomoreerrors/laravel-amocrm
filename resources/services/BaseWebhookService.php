<?php

namespace Resources\Services;

use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Обработка полученных данных 
 */
class BaseWebhookService
{

    /**
     * Остановка цикла и ограничение кол-ва запросов к API
     */
    public function preventRequestInfiniteLoop(?array $lastRequestTime, string $accountId, string $lastLeadId)
    {
         info('inside preventRequestInfiniteLoop '. __CLASS__);

         if($lastRequestTime && 
           array_key_exists($accountId, $lastRequestTime) &&
           array_key_exists('last_lead_id', $lastRequestTime[$accountId]) &&
           $lastRequestTime[$accountId]['last_lead_id'] === $lastLeadId &&
           $lastRequestTime[$accountId]['last_request_time'] >= time()) {

                info('Остановка цикла запросов. ',
                    ['Время предыдущего запроса: '. $lastRequestTime[$accountId]['last_request_time']
                        .' Новый запрос: ' . time().' '
                    . __CLASS__ . __LINE__, 'lead_id :'.$lastRequestTime[$accountId]['last_lead_id']]);

                return response('ok');
         }

         $c = $lastRequestTime;


         $c[$accountId]['last_request_time'] = time() + 5;
         $c[$accountId]['last_lead_id'] = $lastLeadId;

    
         
         Storage::put('lastRequestTime.txt', json_encode($c));

    }







}