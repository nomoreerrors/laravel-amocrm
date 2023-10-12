<?php

declare(strict_types=1);

namespace App\Http\Controllers\AmoCRM;

use AmoCRM\Models\LeadModel;
use App\Models\AmoCRM\AmoCrmConnectionModel;
use Illuminate\Http\Request;
use Resources\Services\WebhookLeadUpdateService;
use App\Http\Controllers\AmoCRM\BaseController;
use App\Http\classes\AmoCRMConfig;
use App\Http\classes\AmoCRMRepository;
use Exception;
use App\Http\classes\MyMock;
use Illuminate\Support\Facades\Storage;
use Resources\Factories\LeadsFactory;
use App\Jobs\CacheRequestsJob;
use PHPUnit\Framework\MockObject\Generator\MockClass;

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
    protected function getWebHookLeadUpdates(Request $request)
    {   
       
        // grep -wrin "declare" vendor/amocrm/amocrm-api-library   
        $data = $request->except('state');

        CacheRequestsJob::dispatch($data);
        // return response('send to queue');
    }




    protected function test(Request $request)
    {   
            
        $data = $request->all();
        Storage::append('UHOOK.txt', json_encode([$request->all(), $request->server()]));



        $this->service->setData($data);

        $lastLeadId = $this->service->getKeyFromLead('id'); 

        info('incoming request to TEST. ', ['Lead id: '.$lastLeadId]);

        // return response('ok');

    }

}