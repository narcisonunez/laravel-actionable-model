<?php


namespace Narcisonunez\LaravelActionableModel\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActionableRecord extends Model
{
    protected $guarded = [];

    /**
     * @return BelongsTo
     */
    public function owner() : BelongsTo
    {
        return $this->belongsTo($this->owner_type, 'owner_id');
    }

    /**
     * @return BelongsTo
     */
    public function actionable() : BelongsTo
    {
        return $this->belongsTo($this->actionable_type, 'actionable_id');
    }
}
