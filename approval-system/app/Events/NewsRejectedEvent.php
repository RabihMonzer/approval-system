<?php

namespace App\Events;

use App\Dictionaries\EmailSubjectsDictionary;
use App\RejectedNewsLog;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewsRejectedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var RejectedNewsLog
     */
    private $rejectedNewsLog;

    public function __construct(RejectedNewsLog $rejectedNewsLog)
    {
        $this->rejectedNewsLog = $rejectedNewsLog;
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

    public function getRejectedNewsLog(): RejectedNewsLog
    {
        return $this->rejectedNewsLog;
    }

    public function getEmailSubject(): string
    {
        return EmailSubjectsDictionary::NEWS_REJECTED;
    }
}
