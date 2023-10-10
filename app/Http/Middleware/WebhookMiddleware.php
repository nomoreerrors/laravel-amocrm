<?php

declare(strict_types=1);

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
    private int $primeCostFieldId = 2505835;

  


    public function __construct(protected WebhookLeadUpdateService $service){}


    /**
     * Handle an incoming request.
     * @method Illuminate\Support\Facades\App
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * 
     */
    public function handle(Request $request, Closure $next): Response
    {
        $data = $request->all();
        Storage::append('HOOK.txt', json_encode([$request->all(), $request->server()]));
        $service = (new WebhookLeadUpdateService(new AmoCRMRepository()))->setData($data);
        
        App::instance(WebhookLeadUpdateService::class, $service);

        $this->service->setData($data);
        $lastLeadId = $this->service->getLeadId(); 


        
        $state = (new AmoCRMConfig)->state;
        $requestState = $data['state'];

        info('incoming request. ', ['Lead id: '.$lastLeadId]);

        // $lastRequestTime = json_decode(Storage::get('lastRequestTime.txt'), true);
        $result = $this->service->checkState($state, $requestState);
        if(!$result) {
            return response('Wrong state');
            exit;
        }
                        // ->preventRequestInfiniteLoop($lastRequestTime, $accountId, $lastLeadId);


        $price = $this->service->getKeyFromLead('price');
        $primeCost = $this->service->getCustomFieldValue($this->primeCostFieldId); 

        if(!$price || !$primeCost) {
            info('Поле бюджет или себестоимость не заполнено '. 'Lead id: '.$lastLeadId);
            return response('Поле бюджет или себестоимость не заполнено ');
        }

        
        return $next($request);
    }
}
