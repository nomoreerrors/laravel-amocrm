<?php

namespace App\Http\Classes;

use stdClass;

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



    private function getFieldByName(array $data, string $field): array
    {
        static $a = [];
        static $c = [];
            foreach($data as $key => $value) {
                if($key == $field) {
                    $a[$key] = $value;
                }
                foreach($value as $key2 => $value2) {
                    if($key2 == $field) {
                    $a[$key2] = $value2;
                }
                if(gettype($value2) == 'array') {
                    $c[$key2] = $value2;
                };
                };
            };
            if(count($a) == 0) {
                $this->getFieldByName($c, $field);
            } 
            //throw exception?
        return $a;
    }



    public function getCustomFields(): array
    {
        return $this->getFieldByName($this->data, 'custom_fields')['custom_fields'];
    }

    /**
     * Добавить параметр получения конкретного свойства или нескольких из поля update
     */
    public function getUpdate(string $value): array
    {
        return $this->getFieldByName($this->data, 'update')['update'];
        //parameters ['id', 'account_id', 'custom_fields'];
        // $c = $this->getFieldByName($this->data, 'update');
        // foreach($c as $key){
        // $c[$key]
        //return all parameters
        // }

    }


    public function getLeads(): array
    {
        return $this->getFieldByName($this->data, 'leads')['leads'];

    }


    public function getAccount(): array
    {
        return $this->getFieldByName($this->data, 'account')['account'];

    }


    public function getValues(): array
    {
        return $this->getFieldByName($this->data, 'values')['values'];

    }

 
 




}