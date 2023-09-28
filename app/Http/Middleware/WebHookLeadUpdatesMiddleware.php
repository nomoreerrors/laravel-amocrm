<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Http\classes\AmoCRMConfig;
use Exception;

class WebHookLeadUpdatesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, AmoCRMConfig $config): Response
    {
        $state = $config['state'];

         /** Сохранить на сервере request */
         Storage::put('HOOK.txt', json_encode($request->all()));
         Log::info('Входящий запрос');
         $requestState = $request->state;

         if((int)($requestState) !== (int)$state) {
             throw new Exception('Неверный state в параметре запроса webhook' . __CLASS__);
         }
        return $next($request);
    }
}
