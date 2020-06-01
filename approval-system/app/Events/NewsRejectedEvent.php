<?php

namespace App\Events;

use App\Dictionaries\EmailSubjectsDictionary;
use App\RejectedMaterialLog;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewsRejectedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var RejectedMaterialLog
     */
    private $rejectedMaterialLog;

    public function __construct(RejectedMaterialLog $rejectedMaterialLog)
    {
        $this->rejectedMaterialLog = $rejectedMaterialLog;
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

    public function getRejectedMaterialLog(): RejectedMaterialLog
    {
        return $this->rejectedMaterialLog;
    }

    public function getEmailSubject(): string
    {
        return EmailSubjectsDictionary::NEWS_REJECTED;
    }
}
