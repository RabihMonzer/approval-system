<?php

declare(strict_types=1);

namespace App\Events;

use App\Dictionaries\EmailSubjectsDictionary;
use App\Dictionaries\MaterialStatusDictionary;
use App\Material;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MaterialApprovedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Material
     */
    private $material;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Material $material)
    {
        $this->material = $material;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }

    public function getMaterial(): Material
    {
        return $this->material;
    }

    public function getEmailSubject(): string
    {
        return EmailSubjectsDictionary::MATERIAL_APPROVED;
    }
}
