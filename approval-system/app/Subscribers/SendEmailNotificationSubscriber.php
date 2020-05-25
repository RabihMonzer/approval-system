<?php

declare(strict_types=1);

namespace App\Subscribers;

use App\Dictionaries\EmailSubjectsDictionary;
use App\Events\MaterialApprovedEvent;
use App\Events\MaterialRejectedEvent;
use App\User;
use Illuminate\Support\Facades\Mail;

class SendEmailNotificationSubscriber
{
    public function subscribe($events)
    {
        $events->listen(MaterialApprovedEvent::class, 'App\Subscribers\SendEmailNotificationSubscriber@sendEmailNotificationForMaterialApproval');
        $events->listen(MaterialRejectedEvent::class, 'App\Subscribers\SendEmailNotificationSubscriber@sendEmailNotificationForMaterialRejection');
    }

    public function sendEmailNotificationForMaterialApproval($event)
    {
        $currentLoggedInUser = auth()->user();

        $material = $event->getMaterial();

        if ($material->user->isNot($currentLoggedInUser)) {
            $this->sendEmail($material->user->email, $currentLoggedInUser->email, $event->getEmailSubject());
        }
    }

    public function sendEmailNotificationForMaterialRejection($event)
    {
        $currentLoggedInUser = auth()->user();

        $rejectedMaterialLog = $event->getRejectedMaterialLog();

        if ($rejectedMaterialLog->user->isNot($currentLoggedInUser)) {
            $this->sendEmail($rejectedMaterialLog->user->email, $currentLoggedInUser->email, $event->getEmailSubject());
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
