<?php

namespace Resources\Services;

use Resources\Services\BaseWebhookService;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

use App\Http\classes\AmoCRMRepository;
use ErrorException;


/**
 * Обработка полей полученных с webhook данных 
 */
class WebhookLeadUpdateService extends BaseWebhookService
{   
    /**
     * Полученные данные с webhook.
     * @var array
     */
    private array $data;
    private $crmRepository;



    
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->crmRepository = new AmoCRMRepository();

    }



    /**
     * Возвращает всё поле - custom_fields или один из его объектов по id.
     *  @throws Exception
     */
    public function getCustomFields()
    {   
        $result = Arr::get($this->data, 'leads.update.0.custom_fields');
        return $result;

    }
    

    /**
     * Возвращает объект leads->update/add по ключу.
     * @throws Exception
     */
    public function getKeyFromLeads(?string $key = null): array | string
    {
        $c = $this->checkIfUpdateFieldExists();

        if(!$key) {
            $result = Arr::get($this->data, 'leads.'.$c );
            if($result) {
                return $result;
            }
            else throw new ErrorException('Ключ update или add не найден');
        }

            $result = Arr::get($this->data, 'leads.'.$c.'.0');
            if(array_key_exists($key, $result)) {
                return $result[$key];
            }
            else throw new ErrorException('Ключ '.$key.' не найден');

    }

    
    /**
     * Возвращает массив leads из webhook
     */
    public function getLeads(): array 
    {       
           $result = Arr::get($this->data, 'leads');
           return $result;
    }




    /**
     * Возвращает массив webhook - account.
     */
    public function getAccount(?string $key = ''): string | array
    {
       if(!$key) {
           $result = Arr::get($this->data, 'account');
           return $result;
       }
       else {
           $result = Arr::get($this->data, 'account.'.$key);
           if($result) {
                return $result;
           }
           else {
                Log::info('Поле value  не найдено. ', [__CLASS__, __LINE__]);
                return null;
           }
       }
    }


    /**
     * Проверяем - создана сделка или обновлена
     * @return string update/add
     */
    private function checkIfUpdateFieldExists(): string
    {   
        Arr::get($this->data, 'leads.update') ? $result = 'update' : $result = 'add';
        return $result;
    }


    
    /**
     * Возвращает значение custom_fields value объекта webhook по id кастомного поля
     * @throws Exception
     * @return string
     */
    public function getCustomFieldValue(int $id): string | null
    {
        $result = $this->checkIfUpdateFieldExists();
        $d = Arr::get($this->data, 'leads.'.$result.'.0.custom_fields');

        try {
        foreach($d as $obj) {
            if($obj['id'] == $id) {
                return $obj['values'][0]['value'];
            }
            }
        } catch(ErrorException) {
                Log::info('Поле value с id '.$id.' не найдено. ', [__CLASS__, __LINE__]);
                return null;
            } 
        }

    


    /**
     * Обновить поле "Себестоимость".
     * @param int $primeCostFieldId id поля "себестоимость"
     * @param int $primeCostFieldId id поля "прибыль"
     */
    public function updateProfitField(int $primeCostFieldId, int $profitFieldId): void
    {
        $accountId = $this->getAccount('id'); 
       

        $primeCost = $this->getCustomFieldValue($primeCostFieldId); 
        $price = $this->getKeyFromLeads('price');
        $leadId = $this->getKeyFromLeads('id');

        Log::info('6 updateprofilefield' , [__CLASS__]);
        $profit = (int)$price - (int)$primeCost;
        $profitFieldId = $profitFieldId;
        $accountId = $accountId;

        $this->crmRepository->setCustomFieldsValue($profitFieldId, $profit, $leadId);


    }


    public function checkState(string $state, string $requestState)
    {
        if((int)($requestState) !== (int)$state) {
            response('ok');
            throw new Exception('Неверный state в параметре запроса webhook' . __CLASS__);
            die;
        }
        return $this;
    }



}