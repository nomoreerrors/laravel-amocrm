<?php

namespace App\Http\Classes;

use Exception;

/**
 * Обработка полей полученных данных 
 */
class BaseRequestHandler
{

    private array $data;


 
    /**
     * Возвращает любой элемент вложенного массива по ключу
     * @throws Exception
     */
    protected function getFieldByName(array $data, string $field): array
    {
        static $a = [];
        $c = [];
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
            if(count($a) == 0 && $c !== []) {
                $this->getFieldByName($c, $field);
            } 
            
        return count($a) == 0 ? throw new Exception('Ключ с именем ' .$field. ' не существует') : $a;
    }


    /**
     * Возвращает элемент массива по id
     */
    protected function getFieldById(array $array, int $id): array
    {
        
        static $c = [];
        foreach($array as $key => $value) {
            if((int)($value['id']) == $id) {
                $c = $value;
            }
        }
        return count($c) == 0 ? throw new Exception('Ключ с id ' .$id. ' не существует') : $c;

    }


  

}