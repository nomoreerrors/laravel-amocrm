<?php

namespace App\Http\Controllers\AmoCRM;

use AmoCRM\Models\LeadModel;
use App\Models\AmoCRM\AmoCrmConnectionModel;
use Illuminate\Http\Request;
use Resources\Services\WebhookLeadUpdateService;
use App\Http\Controllers\AmoCRM\BaseController;
use App\Http\classes\AmoCRMConfig;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Storage;
use Resources\Factories\LeadsFactory;
use App\Jobs\CacheRequestsJob;

class AmoCrmController extends BaseController
{   

    public function __construct(protected WebhookLeadUpdateService $service, 
                                protected AmoCRMConfig $config 
                                ){}

    
    /**
     * Аутентификация по коду авторизации и получение access token
     */
    protected function authByCode(AmoCrmConnectionModel $crm): void
    {
        $crm->connect($this->config);
    }
  



    /**
     * Обработка входящих данных с webhook
     */
    protected function getWebHookLeadUpdates(Request $request, WebhookLeadUpdateService $service)
    {   
        $data = $request->except('state');

        CacheRequestsJob::dispatch($request->except('state'));
        return response('ok');
       
       
    }




    protected function test(Request $request)
    {   
            
        $data = $request->all();
        Storage::append('UHOOK.txt', json_encode([$request->all(), $request->server()]));

       

        $this->service->setData($data);
        $lastRequestTime = json_decode(Storage::get('lastRequestTime.txt'), true);
        $lastLeadId = $this->service->getKeyFromLeads('id'); 

        info('incoming request to TEST. ', ['Lead id: '.$lastLeadId]);

        return response('ok');

    }

}