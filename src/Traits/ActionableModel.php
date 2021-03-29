<?php


namespace Narcisonunez\LaravelActionableModel\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Narcisonunez\LaravelActionableModel\ActionableActionTypes;
use Narcisonunez\LaravelActionableModel\ActionableModelAliases;
use Narcisonunez\LaravelActionableModel\ActionableRecordHandler;
use Narcisonunez\LaravelActionableModel\Models\ActionableRecord;

trait ActionableModel
{
    /**
     * @return BelongsToMany
     */
    public function actions()
    {
        $aliasHandler = app(ActionableModelAliases::class);
        return $this
            ->hasMany(ActionableRecord::class, 'performed_by_id', 'id')
            ->where('performed_by_type', $aliasHandler->get($this::class))
            ->orWhere(function ($query) use ($aliasHandler) {
                $query->where('actionable_type', $aliasHandler->get($this::class))
                    ->where('actionable_id', $this->id);
            });
    }

    /**
     * @return ActionableRecordHandler
     */
    public function actionsFilter() : ActionableRecordHandler
    {
        $actions = $this->actions->map(function ($action) {
            $implementation = app(ActionableActionTypes::class)->get($action->action);

            return new $implementation($action);
        });

        return new ActionableRecordHandler($this, $actions);
    }
}
