<?php


namespace Narcisonunez\LaravelActionableModel\Traits;


use Illuminate\Database\Eloquent\Model;
use Narcisonunez\LaravelActionableModel\OwnerActionHandler;

trait CanPerformActions
{
    /**
     * @param Model $actionable
     * @return OwnerActionHandler
     */
    public function performActionOn(Model $actionable): OwnerActionHandler
    {
        // TODO Check if actionable use the Trait CanBeActionable
        return (new OwnerActionHandler($this, $actionable));
    }

    public function hasPerformedAction(string $action)
    {
        $actionHandler = new OwnerActionHandler();
        $actionHandler->setOwner($this);
        $actionHandler->setAction($action);
        return $actionHandler;
    }
}
