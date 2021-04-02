<?php


namespace Narcisonunez\LaravelActionableModel\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Narcisonunez\LaravelActionableModel\Models\ActionableRecord;

class ActionOccurred
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /** @var ActionableRecord */
    public ActionableRecord $action;

    /** @var string */
    public string $type;

    /**
     * Create a new event instance.
     *
     * @param ActionableRecord $action
     * @param string $type
     */
    public function __construct(ActionableRecord $action, string $type)
    {
        $this->action = $action;
        $this->type = $type;
    }
}
