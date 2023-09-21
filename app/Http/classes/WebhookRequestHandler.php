<?php

namespace App\Http\Classes;

use App\Http\Classes\BaseRequestHandler;
use Exception;


/**
 * Обработка полей полученных данных 
 */
class WebhookRequestHandler extends BaseRequestHandler
{
    private array $data;
  

    public function __construct(array $data)
    {
        $this->data = $data;
    }



    /**
     * Возвращает всё поле - custom_fields или один из его объектов по id
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
     * Возвращает поле webhook - update или один из его объектов по id
     */
    public function getUpdate(int $id = null): array
    {
        $c = [];
        if(!$id) {
            $c = $this->getFieldByName($this->data, 'update')['update'];
            return $c;

        } else {
            $array = $this->getFieldByName($this->data, 'update')['update'];
            $c = $this->getFieldById($array, $id);
            return $c;
        }
    }

    

    /**
     * Возвращает поле webhook - leads 
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
     * Возвращает поле webhook - update или один из его элементов по ключу
     */
    public function getAccount(string $key = null): array | string 
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
     * Возвращает все значения values или по id содержащего это значение объекта
     */
    public function getCustomFieldsValues(int $id = null): array | string
    {
        $c = $this->getCustomFields();
        if(!$id) {
            return $c;
        } else {
            $d = $this->getFieldById($c, $id);
            return $d['values'];
        }
    }

     
 




}