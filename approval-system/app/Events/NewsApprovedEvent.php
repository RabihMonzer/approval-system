<?php

declare(strict_types=1);

namespace App\Events;

use App\Dictionaries\EmailSubjectsDictionary;
use App\News;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewsApprovedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var News
     */
    private $news;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(News $news)
    {
        $this->news = $news;
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

    public function getNews(): News
    {
        return $this->news;
    }

    public function getEmailSubject(): string
    {
        return EmailSubjectsDictionary::NEWS_APPROVED;
    }
}
