<?php


namespace Narcisonunez\LaravelActionableModel;


use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Model;
use Narcisonunez\LaravelActionableModel\Models\ActionableRecord;

class OwnerActionHandler
{
    /**
     * @var string
     */
    protected string $action;

    /**
     * @var Model
     */
    protected $owner;

    /**
     * @var Model
     */
    protected $actionable;

    /**
     * @var Application|mixed|ActionableActionTypes
     */
    protected $actionableActionTypes;

    public function __construct($owner = null, $actionable = null)
    {
        $this->owner = $owner;
        $this->actionable = $actionable;
        $this->actionableActionTypes = app(ActionableActionTypes::class);
    }

    /**
     * @param Model $actionable
     * @return ActionableTypeRecord|bool
     */
    public function on(Model $actionable) : ActionableTypeRecord|bool
    {
        /** @var ActionableTypeRecord $implementation */
        $implementation = $this->actionableActionTypes->get($this->action);

        $record = ActionableRecord::where('owner_type', $this->owner::class)
            ->where('owner_id',  $this->owner->id)
            ->where('actionable_type',  $actionable::class)
            ->where('actionable_id',  $actionable->id)
            ->first();
        return ! $record ?: (new $implementation($record));
    }

    public function setOwner(Model $model)
    {
        $this->owner = $model;
    }

    public function setAction(string $action)
    {
        $this->action = $action;
    }

    /**
     * @param string $name
     * @param array $arguments
     * @throws Exception
     */
    public function __call(string $name, array $arguments)
    {
        if (! $this->actionableActionTypes->exists($name)) {
            throw new Exception("Invalid Action Type: $name");
        }

        $this->createActionRecord($name);
    }

    /**
     * @param string $name
     */
    public function createActionRecord(string $name): void
    {
        ActionableRecord::create([
            'owner_type' => $this->owner::class,
            'owner_id' => $this->owner->id,
            'actionable_type' => $this->actionable::class,
            'actionable_id' => $this->actionable->id,
            'action' => $name
        ]);
    }
}
