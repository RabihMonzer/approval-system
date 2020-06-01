<?php

declare(strict_types=1);

namespace App\Subscribers;

use App\Dictionaries\EmailSubjectsDictionary;
use App\Events\NewsApprovedEvent;
use App\Events\NewsRejectedEvent;
use App\User;
use Illuminate\Support\Facades\Mail;

class SendEmailNotificationSubscriber
{
    public function subscribe($events)
    {
        $events->listen(NewsApprovedEvent::class, 'App\Subscribers\SendEmailNotificationSubscriber@sendEmailNotificationForNewsApproval');
        $events->listen(NewsRejectedEvent::class, 'App\Subscribers\SendEmailNotificationSubscriber@sendEmailNotificationForNewsRejection');
    }

    public function sendEmailNotificationForNewsApproval($event)
    {
        $currentLoggedInUser = auth()->user();

        $news = $event->getNews();

        if ($news->createdBy->isNot($currentLoggedInUser)) {
            $this->sendEmail($news->createdBy->email, $currentLoggedInUser->email, $event->getEmailSubject());
        }
    }

    public function sendEmailNotificationForNewsRejection($event)
    {
        $currentLoggedInUser = auth()->user();

        $rejectedNewsLog = $event->getRejectedNewsLog();

        if ($rejectedNewsLog->owner->isNot($currentLoggedInUser)) {
            $this->sendEmail($rejectedNewsLog->owner->email, $currentLoggedInUser->email, $event->getEmailSubject());
        }
    }

    private function sendEmail(string $toEmail, string $fromEmail, ?string $subject): void
    {
        Mail::raw('It Works', function ($message) use ($toEmail, $fromEmail, $subject) {
            $message->to($toEmail)
                ->subject($subject)
                ->from($fromEmail);
        });
    }
}
