<?php

namespace App\Models\AmoCRM;

use App\Models\CrmConnectionInterface;


class BaseAmoCrmConnectionModel implements CrmConnectionInterface
{
    public function connect($config): void
    {
        //
    }
}
