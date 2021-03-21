<?php


namespace Narcisonunez\LaravelActionableModel\Traits;


use Exception;
use Illuminate\Database\Eloquent\Model;
use Narcisonunez\LaravelActionableModel\Contracts\CanBeActionable;
use Narcisonunez\LaravelActionableModel\OwnerActionHandler;

trait CanPerformActions
{
    /**
     * @param Model $actionable
     * @return OwnerActionHandler
     * @throws Exception
     */
    public function performActionOn(Model $actionable): OwnerActionHandler
    {
        if (! $actionable instanceof CanBeActionable) {
            throw new Exception("Model " . get_class($actionable) . " " . CanBeActionable::class);
        }
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
