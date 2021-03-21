<?php


namespace Narcisonunez\LaravelActionableModel;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Builder;
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
     * @var Builder
     */
    protected Builder $recordsQuery;

    /**
     * @var Application|mixed|ActionableActionTypes
     */
    protected $actionableActionTypes;

    public function __construct($target)
    {
        $this->target = $target;
        $this->actionableActionTypes = app(ActionableActionTypes::class);
        $this->recordsQuery = ActionableRecord::query();
    }

    /**
     * @param $owner
     * @return $this
     */
    public function by($owner) : self
    {
        $this->recordsQuery->where('performed_by_type',  $owner::class)
            ->where('performed_by_id',  $owner->id);
        return $this;
    }

    /**
     * @param string $action
     * @return $this
     */
    public function ofType(string $action) : self
    {
        $this->recordsQuery->where('action',  $action);

        return $this;
    }

    /**
     * @return $this
     */
    public function received(): self
    {
        $this->recordsQuery->where('actionable_type',  $this->target::class)
            ->where('actionable_id',  $this->target->id);

        return $this;
    }

    /**
     * @return $this
     */
    public function given(): self
    {
        $this->recordsQuery->where('performed_by_type',  $this->target::class)
            ->where('performed_by_id',  $this->target->id);

        return $this;
    }

    /**
     * Returns a collection of ActionableRecord
     */
    public function get() : Collection
    {
        return $this->recordsQuery->get()
            ->map(function (ActionableRecord $record) {
                $implementation = $this->actionableActionTypes->get($record->action);

                return new $implementation($record);
            });
    }

    /**
     * @return int
     */
    public function count() : int
    {
        return $this->recordsQuery->count();
    }
}
