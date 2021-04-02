<?php


namespace Narcisonunez\LaravelActionableModel;

use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Narcisonunez\LaravelActionableModel\Events\ActionOccurred;
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

    /**
     * @var ActionableModelAliases
     */
    protected ActionableModelAliases $aliasHandler;

    public function __construct($owner = null, $actionable = null)
    {
        $this->owner = $owner;
        $this->actionable = $actionable;
        $this->actionableActionTypes = app(ActionableActionTypes::class);
        $this->aliasHandler = app(ActionableModelAliases::class);
    }

    /**
     * @param Model $actionable
     * @return mixed
     */
    public function on(Model $actionable) : mixed
    {
        /** @var string $implementation */
        $implementation = $this->actionableActionTypes->get($this->action);

        $record = ActionableRecord::where('performed_by_type', $this->getOwnerAlias())
            ->where('performed_by_id', $this->owner->id)
            ->where('actionable_type', $this->aliasHandler->get($actionable::class))
            ->where('actionable_id', $actionable->id)
            ->where('action', $this->action)
            ->first();

        return ! $record ? false : (new $implementation($record));
    }

    /**
     * @param Model $model
     */
    public function setOwner(Model $model) : self
    {
        $this->owner = $model;

        return $this;
    }

    /**
     * @param string $action
     */
    public function setAction(string $action) : self
    {
        $this->action = $action;

        return $this;
    }

    public function toggle($action)
    {
        $this->validateAction($action);
        $records = $this->getRecordsForAction($action);

        if ($records->isNotEmpty()) {
            $recordsCount = $records->count();
            $records->map(function ($record) {
                ActionOccurred::dispatch($record, 'delete');
                $record->delete();
            });

            return $recordsCount;
        }

        return $this->createActionRecord($action);
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return int|ActionableRecord
     * @throws Exception
     */
    public function __call(string $name, array $arguments) : ActionableRecord | int
    {
        if (Str::startsWith($name, 'toggle')) {
            $name = Str::lower(Str::replaceFirst('toggle', '', $name));
            $this->validateAction($name);

            return $this->toggle($name);
        }

        $this->validateAction($name);

        return $this->createActionRecord($name);
    }

    /**
     * @param string $name
     * @return ActionableRecord
     */
    public function createActionRecord(string $name): ActionableRecord
    {
        $record = ActionableRecord::create([
            'performed_by_type' => $this->getOwnerAlias(),
            'performed_by_id' => $this->owner->id,
            'actionable_type' => $this->aliasHandler->get($this->actionable::class),
            'actionable_id' => $this->actionable->id,
            'action' => $name,
        ]);
        ActionOccurred::dispatch($record, 'create');

        return $record;
    }

    /**
     * @param $action
     * @return Collection|null
     */
    public function getRecordsForAction($action) : Collection | null
    {
        return ActionableRecord::where('performed_by_type', $this->getOwnerAlias())
            ->where('performed_by_id', $this->owner->id)
            ->where('actionable_type', $this->aliasHandler->get($this->actionable::class))
            ->where('actionable_id', $this->actionable->id)
            ->where('action', $action)
            ->get();
    }

    /**
     * @param string $name
     * @throws Exception
     */
    public function validateAction(string $name): void
    {
        if (! $this->actionableActionTypes->exists($name)) {
            throw new Exception("Invalid Action Type: $name");
        }
    }

    /**
     * @return string
     */
    public function getOwnerAlias(): string
    {
        return $this->aliasHandler->get($this->owner::class);
    }
}
