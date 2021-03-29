<?php


namespace Narcisonunez\LaravelActionableModel;


class ActionableModelAliases
{
    /**
     * @var array
     */
    protected array $aliases;

    /**
     * @param array $aliases
     */
    public function register(array $aliases)
    {
        $this->aliases = $aliases;
    }


    /**
     * @param string $model
     * @return mixed
     */
    public function get(string $model) : string
    {
        return isset($this->aliases[$model]) ? $this->aliases[$model] : $model;
    }

    /**
     * @param string $alias
     * @return string
     */
    public function model(string $alias) : string
    {
        return collect($this->aliases)
            ->filter(function($item) use ($alias){
                return $item === $alias;
            })->keys()->first() ?: $alias;
    }
}
