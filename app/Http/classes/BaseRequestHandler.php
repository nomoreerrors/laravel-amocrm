<?php

namespace App\Http\Classes;

use Exception;
use Illuminate\Support\Facades\Log;

/**
 * Обработка полей полученных данных 
 */
class BaseRequestHandler
{

    /**
     * Возвращает любой элемент вложенного массива по ключу
     * @throws Exception
     */
    protected function getFieldByName(array $data, string $field): array
    {   
        static $a = [];
        // $c = [];
        // dd($a, $c);
            foreach($data as $key => $value) {
                Log:info($key);
                if($key == $field) {
                    $a[$key] = $value;
                }  
                try { 
                        foreach($value as $key2 => $value2) {
                            // Log::info('errors: ', [$value, $key2, $value2]);
                            if($key2 == $field) {
                            $a[$key2] = $value2;
                        }
                        if(gettype($value2) == 'array') {
                            $c[$key2] = $value2;
                            Log::info($a);
                        };
                        };
                } catch(Exception $e) {
                    Log::error(__METHOD__ . gettype($value) .' '. $value .' ' . __CLASS__);
                    
                } 
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