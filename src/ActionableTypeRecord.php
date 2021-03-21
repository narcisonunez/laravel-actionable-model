<?php


namespace Narcisonunez\LaravelActionableModel;

use Narcisonunez\LaravelActionableModel\Models\ActionableRecord;

class ActionableTypeRecord
{
    /**
     * @var ActionableRecord
     */
    public ActionableRecord $target;

    public function __construct(ActionableRecord $record)
    {
        $this->target = $record;
    }

    /**
     * @param $method
     * @param $args
     * @return mixed
     */
    public function __call($method, $args) : mixed
    {
        return $this->target->{$method}(...$args);
    }

    /**
     * @param $property
     * @return mixed
     */
    public function __get($property) : mixed
    {
        return $this->target->{$property};
    }
}
