<?php


namespace Narcisonunez\LaravelActionableModel\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Narcisonunez\LaravelActionableModel\ActionableActionTypes;
use Narcisonunez\LaravelActionableModel\ActionableRecordHandler;
use Narcisonunez\LaravelActionableModel\Models\ActionableRecord;

trait ActionableModel
{
    /**
     * @return BelongsToMany
     */
    public function actions()
    {
        return $this
            ->hasMany(ActionableRecord::class, 'performed_by_id', 'id')
            ->where('performed_by_type', $this::class)
            ->orWhere(function($query){
                $query->where('actionable_type', $this::class)
                    ->where('actionable_id', $this->id);
            });
    }

    /**
     * @return ActionableRecordHandler
     */
    public function actionsFilter() : ActionableRecordHandler
    {
        $actions = $this->actions->map(function($action){
            $implementation = app(ActionableActionTypes::class)->get($action->action);
            return new $implementation($action);
        });
        return new ActionableRecordHandler($this, $actions);
    }
}
