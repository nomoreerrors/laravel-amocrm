<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Resources\Services\WebhookLeadUpdateService;
use App\Http\classes\AmoCRMConfig;
use App\Http\classes\AmoCRMRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Monolog\Handler\SlackWebhookHandler;

class WebhookMiddleware extends BaseWebhookMiddleware
{   
      /**
     * id поля "Себестоимость" (value). 
     * @var int costPriceId
     */
    private $primeCostFieldId = 2505835;

  


    public function __construct(protected WebhookLeadUpdateService $service){}


    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $data = $request->all();
        Storage::append('HOOK.txt', json_encode([$request->all(), $request->server()]));

        $service = (new WebhookLeadUpdateService(new AmoCRMRepository()))->setData($data);
        App::instance(WebhookLeadUpdateService::class, $service);

        // $this->service->setData($data);
        // $lastRequestTime = json_decode(Storage::get('lastRequestTime.txt'), true);
        // $lastLeadId = $this->service->getKeyFromLeads('id'); 

        // info('incoming request. ', ['Lead id: '.$lastLeadId]);



        // $accountId = $this->service->getAccount('id'); 
        // $state = (new AmoCRMConfig)->state;
        // $requestState = $data['state'];



        // $this->service->checkState($state, $requestState)
        //                 ->preventRequestInfiniteLoop($lastRequestTime, $accountId, $lastLeadId);


        // $price = $this->service->getKeyFromLeads('price');
        // $primeCost = $this->service->getCustomFieldValue($this->primeCostFieldId); 

        // if(!$price || !$primeCost) {
        //     info('Поле бюджет или себестоимость не заполнено '. 'Lead id: '.$lastLeadId);
        //     return response('ok');
        // }


        return $next($request);
    }
}