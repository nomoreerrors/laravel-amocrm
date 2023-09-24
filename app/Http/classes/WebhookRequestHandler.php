<?php

namespace App\Http\Classes;

use App\Http\Classes\BaseRequestHandler;
use Exception;


/**
 * Обработка полей полученных данных 
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
    public function getCustomFields(?int $id = null): array
    {   
        
        $c = $this->getFieldByName($this->data, 'custom_fields')['custom_fields'];

        if(!$id) {
            return $c;

        } else {
            $d = $this->getFieldById($c, $id);
            return $d;
        }

    }
    

    /**
     * Возвращает поле webhook - update или один из его объектов по id.
     * @throws Exception
     */
    public function getUpdate(int $id = null): array
    {
        $c = $this->getFieldByName($this->data, 'update')['update'];
        if(!$id) {
            return $c;
        };

        $d = $this->getFieldById($c, $id);
        return $d;
        
    }

    

    /**
     * Возвращает поле webhook - leads.
     */
    public function getLeads(): array
    {       
         $c = $this->getFieldByName($this->data, 'leads')['leads'];
         if(!$c) {
            throw new Exception('Поле Leads не существует');

         } else {
            return $c;
         }
    }



    /**
     * Возвращает поле webhook - update, или один из его элементов по ключу.
     */
    public function getAccount(?string $key = null): array | string 
    {
        $c = $this->getFieldByName($this->data, 'account')['account'];
        if(!$key) {
            return $c;
        }
        if(isset($c[$key])) {
            return $c[$key];
        }
        else throw new Exception('Account не содержит объект с таким ключом');
    }

    

    /**
     * Возвращает значение custom_fields value объекта webhook
     * @var int $id custom_fields object id
     * @throws Exception
     * @return string
     */
    public function getCustomFieldsValue(int $id): string
    {
        $c = $this->getCustomFields($id)['values'][0]['value'];
        return $c;
    }

     
 




}