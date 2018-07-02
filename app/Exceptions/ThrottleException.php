<?php

namespace App\Exceptions;

use Exception;

class ThrottleException extends Exception
{
    public function render()
    {
        return response('To many requests', 429);
    }
}
