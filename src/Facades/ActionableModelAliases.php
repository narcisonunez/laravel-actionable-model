<?php

namespace Narcisonunez\LaravelActionableModel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Narcisonunez\LaravelActionableModel\ActionableModelAliases
 * @method static register(string[] $array)
 * @method static get(string[] $array)
 * @method static all(string[] $array)
 * @method static model(string[] $array)
 */
class ActionableModelAliases extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Narcisonunez\LaravelActionableModel\ActionableModelAliases::class;
    }
}
