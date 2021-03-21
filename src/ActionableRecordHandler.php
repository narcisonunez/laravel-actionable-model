<?php


namespace Narcisonunez\LaravelActionableModel;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Action;
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
        $this->recordsQuery->where('owner_type',  $owner::class)
            ->where('owner_id',  $owner->id);
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
        $this->recordsQuery->where('owner_type',  $this->target::class)
            ->where('owner_id',  $this->target->id);
        return $this;
    }

    public function get()
    {
        $records = $this->recordsQuery->get()
            ->map(function (ActionableRecord $record) {
            if($implementation = $this->actionableActionTypes->get($record->action)) {
                return new $implementation($record);
            }

            return $record;
        });

        dd($records);
    }
}