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

        /** Проверка и обновление времени последнего запроса пользователя */

        self::$webHookHandler = new WebhookLeadUpdateService($request->except('state'));
        $accountId = self::$webHookHandler->getAccount('id'); 
        $lastRequestTime = json_decode(Storage::get('lastRequestTime.txt'), true);
        $state = (new AmoCRMConfig)->state;
        $requestState = $request->state;

        self::$webHookHandler->preventRequestInfiniteLoop($lastRequestTime, $accountId);

        self::$webHookHandler->checkRequestLimitPerSecond();
     


        /** Аутентификация webhook по state */

        if((int)($requestState) !== (int)$state) {
            response('ok');
            throw new Exception('Неверный state в параметре запроса webhook' . __CLASS__);
            die;
        }


        /** Сохранить на сервере объект request */
        Storage::put('HOOK.txt', json_encode($request->all()));
        Log::info('Входящий запрос');
         

        return $next($request);
    }




    /**
     * Выполнить после обработки и отправки данных
     */
    public function terminate():void
    {

        $accountId = self::$webHookHandler->getAccount('id');
        $lastRequestTime[$accountId] = time() + 3;
        Storage::put('lastRequestTime.txt', json_encode($lastRequestTime));
        Log::info('Успешный запрос к хуку');
    }
}
