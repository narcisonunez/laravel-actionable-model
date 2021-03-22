<?php


namespace Narcisonunez\LaravelActionableModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

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

    public function __construct($target, $actions)
    {
        $this->target = $target;
        $this->actions = $actions;
    }

    /**
     * @param $owner
     * @return $this
     */
    public function by($owner) : self
    {
        $this->actions = $this->actions->where('target.performed_by_type', $owner::class)
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
        $this->actions = $this->actions->where('target.actionable_type',  $this->target::class)
            ->where('target.actionable_id',  $this->target->id);

        return $this;
    }

    /**
     * @return $this
     */
    public function given(): self
    {
        $this->actions = $this->actions->where('target.performed_by_type',  $this->target::class)
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
     * @return int
     */
    public function count() : int
    {
        return $this->actions->count();
    }
}
