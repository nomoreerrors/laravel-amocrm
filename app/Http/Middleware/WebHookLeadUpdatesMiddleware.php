<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Http\classes\AmoCRMConfig;
use Resources\Services\WebhookLeadUpdateService;
use Exception;

class WebHookLeadUpdatesMiddleware
{

    private static $webHookHandler;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        //Почему два запроса???
        //Почему два запроса???
        //Почему два запроса???
        //Почему два запроса???
        Log::info('request here');
        response('ok');
        die;
        
        /** Сохранить на сервере объект request */
        Storage::put('HOOK.txt', json_encode($request->all()));
        Log::info('Входящий запрос', [__CLASS__, __LINE__]);
        Log::info('1 middleware' , [__CLASS__]);

        
        /** Проверка и обновление времени последнего запроса пользователя */
       
        self::$webHookHandler = new WebhookLeadUpdateService($request->except('state'));
        $accountId = self::$webHookHandler->getAccount('id'); 
        $lastRequestTime = json_decode(Storage::get('lastRequestTime.txt'), true);
        $state = (new AmoCRMConfig)->state;
        $requestState = $request->state;

        /** Аутентификация webhook по state */
        Log::info('checkstate' , [__CLASS__]);
        if((int)($requestState) !== (int)$state) {
            response('ok');
            throw new Exception('Неверный state в параметре запроса webhook' . __CLASS__);
            die;
        }

        self::$webHookHandler->preventRequestInfiniteLoop($lastRequestTime, $accountId);

        self::$webHookHandler->checkRequestLimitPerSecond();
     
        Log::info('died');
        die;

        

        
      
         

        return $next($request);
    }




    /**
     * Выполнить после обработки и отправки данных
     */
    public function terminate():void
    {
        Log::info('8 terminate (окончание)' , [__CLASS__]);

    }
}
