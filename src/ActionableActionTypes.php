<?php


namespace Narcisonunez\LaravelActionableModel;


class ActionableActionTypes
{
    public array $actions;

    /**
     * @param array $actions
     */
    public function register(array $actions)
    {
        $parsedActions = [];
        foreach ($actions as $key => $implementation) {
            if (is_numeric($key)) {
                $parsedActions[$implementation] = ''; // TODO Default class implementation
                continue;
            }

            $parsedActions[$key] = $implementation;
        }
       $this->actions = $parsedActions;
    }

    /**
     * @param string $action
     * @return bool
     */
    public function exists(string $action)
    {
        if (! in_array($action, $this->actions)) {
            return false;
        }

        return true;
    }

    /**
     * @param string $action
     * @return bool|mixed
     */
    public function get(string $action)
    {
        if (! in_array($action, $this->actions)) {
            return false;
        }

        return $this->actions[$action];
    }

    /**
     * @return array
     */
    public function actions()
    {
        return $this->actions;
    }
}
