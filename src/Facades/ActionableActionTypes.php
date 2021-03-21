<?php

namespace Narcisonunez\LaravelActionableModel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Narcisonunez\LaravelActionableModel\LaravelActionableModel
 * @method static register(string[] $array)
 */
class ActionableActionTypes extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Narcisonunez\LaravelActionableModel\ActionableActionTypes::class;
    }
}
