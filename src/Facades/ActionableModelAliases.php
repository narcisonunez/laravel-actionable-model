<?php

namespace Narcisonunez\LaravelActionableModel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Narcisonunez\LaravelActionableModel\ActionableModelAliases
 * @method static register(string[] $array)
 * @method static get(string $string)
 * @method static all()
 * @method static model(string $string)
 */
class ActionableModelAliases extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Narcisonunez\LaravelActionableModel\ActionableModelAliases::class;
    }
}
