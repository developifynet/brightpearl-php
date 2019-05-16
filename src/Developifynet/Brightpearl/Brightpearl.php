<?php

namespace Developifynet\Brightpearl;

use Illuminate\Support\Facades\Facade;

class Brightpearl extends Facade
{
    /**
     * Get the binding in the IoC container
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'brightpearl';
    }
}