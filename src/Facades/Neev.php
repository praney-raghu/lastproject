<?php

namespace Ssntpl\Neev\Facades;

class Neev extends \Illuminate\Support\Facades\Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'neev';
    }
}
