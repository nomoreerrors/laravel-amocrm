<?php

namespace App\Http\Classes;

use App\Http\Classes\BaseRequestHandler;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

/**
 * Обработка полей полученных с webhook данных 
 */
class WebhookRequestHandler extends BaseRequestHandler
{   
    /**
     * Полученные данные с webhook.
     * @var array
     */
    private array $data;


    
    public function __construct(array $data)
    {
        $this->data = $data;
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
            return $result;
        }
        if($key) {
            $result = Arr::get($this->data, 'leads.update.0.'.$key );
            return $result;
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
           return $result;
       }

    }

    

    /**
     * Возвращает значение custom_fields value объекта webhook
     * @throws Exception
     * @return string
     */
    public function getCustomFieldsValues(int $id): array
    {
        $c = Arr::get($this->data, 'leads.update.0.custom_fields');

        foreach($c as $obj) {
            if($obj['id'] == $id) {
                return $obj['values'];
            }
        }
    }

     
 




}