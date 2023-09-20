<?php

namespace App\Http\Classes;

use stdClass;

/**
 * Обработка полей полученных данных 
 */
class WebhookRequestHandler extends BaseRequestHandler
{
    private array $data;
    private array $account;
    private array $leads;
    private array $update;
    private array $custom_fields;


    public function __construct(array $data)
    {
         $this->data = $data;
         $this->custom_fields = $this->getFieldByName($data, 'custom_fields');
         $this->account = $this->getFieldByName($data, 'account');
         $this->leads = $this->getFieldByName($data, 'leads');
         $this->update = $this->getFieldByName($data, 'update');
        
    }

    public function getFieldByName(array $data, string $field): array
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
        return $this->custom_fields;
    }

 
 




}