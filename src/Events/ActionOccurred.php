<?php


namespace Narcisonunez\LaravelActionableModel\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Narcisonunez\LaravelActionableModel\Models\ActionableRecord;
use Narcisonunez\LaravelActionableModel\Traits\ActionableModel;

class ActionOccurred
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var ActionableRecord  */
    public ActionableRecord $action;

    /** @var string  */
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
