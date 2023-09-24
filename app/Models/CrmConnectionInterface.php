<?php

namespace App\Models;

 

interface CrmConnectionInterface
{
    
    public function connect($config): void;
    


}
