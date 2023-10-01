<?php

namespace Resources\Factories;

use Illuminate\Support\Facades\Storage;

class LeadsFactory
{
    private array $data;


    public function __construct()
    {
        $this->data = json_decode(Storage::get('leads_factory.txt'), true);

    }


    public function make(int $leadCount)
    {
        dd($this->data);
        for($i = 0; $i < $leadCount; $i++) {
        
        }
    }
}