<?php


namespace Narcisonunez\LaravelActionableModel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Narcisonunez\LaravelActionableModel\ActionableModelAliases;

class ActionableRecord extends Model
{
    protected $guarded = [];

    /**
     * @var ActionableModelAliases
     */
    protected ActionableModelAliases $aliasHandler;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->aliasHandler = app(ActionableModelAliases::class);
    }

    /**
     * @return BelongsTo
     */
    public function owner() : BelongsTo
    {
        $model = $this->aliasHandler->model($this->performed_by_type);
        return $this->belongsTo($model, 'performed_by_id');
    }

    /**
     * @return BelongsTo
     */
    public function actionable() : BelongsTo
    {
        $model = $this->aliasHandler->model($this->actionable_type);
        return $this->belongsTo($model, 'actionable_id');
    }

    /**
     * Alias for the action attribute
     * @return string
     */
    public function getTypeAttribute() : string
    {
        return $this->attributes['action'];
    }
}
