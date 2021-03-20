<?php

namespace Narcisonunez\LaravelActionableModel;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Narcisonunez\LaravelActionableModel\LaravelActionableModel
 */
class LaravelActionableModelFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-actionable-model';
    }
}
