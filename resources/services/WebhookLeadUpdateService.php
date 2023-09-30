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
    private $crm;
    private $CrmRepository;



    
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->CrmRepository = new AmoCRMRepository();

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
     * Возвращает поле update или один из его объектов.
     * @throws Exception
     */
    public function getUpdate(?string $key = null): array | string
    {
        if(!$key) {
            $result = Arr::get($this->data, 'leads.update' );
            if($result) {
                return $result;
            }
            else throw new ErrorException('Ключ Update не найден');
        }


        if($key) {
            $result = Arr::get($this->data, 'leads.update.0.'.$key );
            if($result) {
                return $result;
            }
            else throw new ErrorException('Ключ не найден');
           
        };
       

    }

    
    /**
     * Возвращает поле leads из webhook object
     */
    public function getLeads(): array 
    {       
           $result = Arr::get($this->data, 'leads');
           return $result;
    }




    /**
     * Возвращает поле webhook - account.
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
     * Возвращает значение custom_fields value объекта webhook по id кастомного поля
     * @throws Exception
     * @return string
     */
    public function getCustomFieldValue(int $id): string | null
    {
        $c = Arr::get($this->data, 'leads.update.0.custom_fields');

        foreach($c as $obj) {
            if($obj['id'] == $id) {
                return $obj['values'][0]['value'];
            }
            
            else {
                Log::info('Поле value  не найдено. ', [__CLASS__, __LINE__]);
                return null;
            } 
        }

    }


    /**
     * Обновить поле "Себестоимость".
     */
    public function updateProfitField(int $primeCostFieldId, int $profitFieldId): void
    {
        $accountId = $this->getAccount('id'); 
       

        $primeCost = $this->getCustomFieldValue($primeCostFieldId); 
        $price = $this->getUpdate('price');
        $updateId = $this->getUpdate('id');

        Log::info('Переменные: ', [$primeCost, $price, $updateId]);
        $profit = (int)$price - (int)$primeCost;
        $profitFieldId = $profitFieldId;
        $accountId = $accountId;
        dd('trying to setcustomfieldsvalue at the end');
        $this->CrmRepository->setCustomFieldsValue($profitFieldId, $profit, $updateId);


    }



}