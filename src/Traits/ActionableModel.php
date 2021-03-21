<?php


namespace Narcisonunez\LaravelActionableModel\Traits;

use Narcisonunez\LaravelActionableModel\ActionableRecordHandler;

trait ActionableModel
{
    /**
     * @return ActionableRecordHandler
     */
    public function actions() : ActionableRecordHandler
    {
        return new ActionableRecordHandler($this);
    }
}
