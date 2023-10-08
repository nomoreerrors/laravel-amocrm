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
    public array $data;



    
    public function __construct(protected AmoCRMRepository $repository){}

    
    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    
    
    public function getCustomFields(): ?array
    {   
        $c = $this->checkIfUpdateFieldExists();
        $result = Arr::get($this->data, 'leads.'.$c.'.0.custom_fields');
        
        if($result) {
            return $result;
        } else {
            Log::error('Поле custom_fields не найдено. '.$this->getLeadId(), [__CLASS__], __METHOD__);
            return null;
        }
    }
    

    /**
     * Возвращает объект leads->update/add по ключу.
     * @throws Exception
     */
    public function getKeyFromLead(string $key): mixed
    {
        $c = $this->checkIfUpdateFieldExists();

        $result = Arr::get($this->data, 'leads.'.$c.'.0');
        if(array_key_exists($key, $result)) {
            return $result[$key];
        }
        else {
            info('Ключ '.$key.' не найден. '.$this->getLeadId(), [__CLASS__, __METHOD__]);
            return null;
        }

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
     * Возвращает массив account или одно из его значений по ключу.
     */
    public function getAccount(?string $key = ''): mixed
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
                Log::info('Ключ '.$key.' не найден. '.$this->getLeadId(), [__CLASS__, __LINE__]);
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
     * Возвращает значение custom_fields - value объекта webhook по id кастомного поля
     * @throws Exception
     * @return string
     */
    public function getCustomFieldValue(string $id): ?string 
    {
        $c = $this->checkIfUpdateFieldExists();
        $result = Arr::get($this->data, 'leads.'.$c.'.0.custom_fields');

        try {
        foreach($result as $obj) {
            if($obj['id'] == $id &&
                array_key_exists('values', $obj)) {
                return $obj['values'][0]['value'];
            }
            }
        } catch(ErrorException) {

                info('Поле value с id '.$id.' не найдено. '.$this->getLeadId(),[__CLASS__, __LINE__]);
                return null;
            } 
    }

    


    /**
     * Обновить поле "Себестоимость".
     * @param int $primeCostFieldId id поля "себестоимость"
     * @param int $profitFieldId id поля "прибыль"
     */
    public function updateProfitField(string $primeCostFieldId, string $profitFieldId)
    {

        $primeCost = $this->getCustomFieldValue($primeCostFieldId); 
        $price = $this->getKeyFromLead('price');
        $leadId = $this->getKeyFromLead('id');

        info('inside updateProfitField' , [__CLASS__]);
        $profit = (int)$price - (int)$primeCost;


        $this->repository->setCustomFieldsValue($profitFieldId, $profit, $leadId);


    }


    public function checkState(string $state, string $requestState)
    {
        if((int)($requestState) !== (int)$state) {
            throw new Exception('Неверный state в параметре запроса webhook '.$this->getLeadId(), __CLASS__);
            return response('ok');
        }
        return $this;
    }


    private function getLeadId(): ?string
    {
        $c = $this->checkIfUpdateFieldExists();
        $result = Arr::get($this->data, 'leads'.$c.'id');
        if($result) {
            return 'Lead id: '.$result;
        } else {
            info('Ключ id или leads не существует', [__METHOD__]);
            return null;
        }
    }


   
     



}