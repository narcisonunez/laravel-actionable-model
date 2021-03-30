<?php


namespace Narcisonunez\LaravelActionableModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Narcisonunez\LaravelActionableModel\Models\ActionableRecord;

class ActionableRecordHandler
{
    /**
     * @var Model
     */
    protected Model $target;

    /**
     * @var Collection
     */
    protected Collection $actions;

    /**
     * @var ActionableModelAliases
     */
    protected ActionableModelAliases $aliasHandler;

    public function __construct($target, $actions)
    {
        $this->target = $target;
        $this->actions = $actions;
        $this->aliasHandler = app(ActionableModelAliases::class);
    }

    /**
     * @param $owner
     * @return $this
     */
    public function by($owner) : self
    {
        $this->actions = $this->actions
            ->where('target.performed_by_type', $this->aliasHandler->get($owner::class))
            ->where('target.performed_by_id', $owner->id);

        return $this;
    }

    /**
     * @param string $action
     * @return $this
     */
    public function ofType(string $action) : self
    {
        $this->actions = $this->actions->where('target.action',  $action);

        return $this;
    }

    /**
     * @return $this
     */
    public function received(): self
    {
        $this->actions = $this->actions
            ->where('target.actionable_type', $this->getTargetAlias())
            ->where('target.actionable_id',  $this->target->id);

        return $this;
    }

    /**
     * @return $this
     */
    public function given(): self
    {
        $this->actions = $this->actions
            ->where('target.performed_by_type',  $this->getTargetAlias())
            ->where('target.performed_by_id',  $this->target->id);

        return $this;
    }

    /**
     * Returns a collection of ActionableRecord
     */
    public function get() : Collection
    {
        return $this->actions;
    }

    /**
     * Returns a collection of ActionableRecord
     * @param int $limit
     * @return Collection
     */
    public function latest($limit = 10) : Collection
    {
        return $this->actions->sortByDesc(function ($action) {
            return $action->created_at;
        })->take($limit);
    }

    /**
     * @return ActionableTypeRecord
     */
    public function first() : ActionableTypeRecord
    {
        return $this->actions->first();
    }

    /**
     * @return ActionableTypeRecord
     */
    public function last() : ActionableTypeRecord
    {
        return $this->latest(1)->first();
    }

    /**
     * @return int
     */
    public function count() : int
    {
        return $this->actions->count();
    }

    /**
     * @return string
     */
    public function getTargetAlias() : string
    {
        return $this->aliasHandler->get($this->target::class);
    }
}
