<?php


namespace Narcisonunez\LaravelActionableModel;

use Exception;

class ActionableActionTypes
{
    /**
     * @var array
     */
    public array $actions;

    /**
     * @param array $actions
     * @throws Exception
     */
    public function register(array $actions)
    {
        $parsedActions = [];
        foreach ($actions as $key => $implementation) {
            if (is_numeric($key)) {
                $parsedActions[$implementation] = ActionableTypeRecord::class;

                continue;
            }

            $this->validateImplementation($implementation);

            $parsedActions[$key] = $implementation;
        }
        $this->actions = $parsedActions;
    }

    /**
     * @param string $action
     * @return bool
     */
    public function exists(string $action) : bool
    {
        if (! isset($this->actions[$action])) {
            return false;
        }

        return true;
    }

    /**
     * @param string $action
     * @return string
     */
    public function get(string $action) : string
    {
        return $this->actions[$action];
    }

    /**
     * @return array
     */
    public function actions()
    {
        return $this->actions;
    }

    /**
     * @param mixed $implementation
     * @throws Exception
     */
    private function validateImplementation(mixed $implementation): void
    {
        if (! class_exists($implementation)) {
            throw new Exception("Class not found. $implementation");
        }

        if (! is_subclass_of($implementation, ActionableTypeRecord::class)) {
            throw new Exception('The implementation should be an instance of ActionableTypeRecord');
        }
    }
}
