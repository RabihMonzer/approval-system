<?php

declare(strict_types=1);

namespace App\Observers;

use App\Dictionaries\EmailSubjectsDictionary;
use App\Dictionaries\NewsStatusDictionary;
use App\News;
use Illuminate\Support\Facades\Mail;

class NewsObserver
{
    public function creating(News $news)
    {
        $this->setNewsStatusAccordingToLoggedInUser($news);
        $news->created_by = auth()->user()->id;
    }

    public function updating(News $news)
    {
        $this->setNewsStatusAccordingToLoggedInUser($news);
        $news->updated_by = auth()->user()->id;
    }

    public function approved(News $news)
    {
        $loggedInUser = auth()->user();

        if ($news->createdBy->isNot($loggedInUser)) {
            Mail::raw('It Works', function ($message) use ($news, $loggedInUser) {
                $message->to($news->createdBy->email)
                    ->subject(EmailSubjectsDictionary::NEWS_APPROVED)
                    ->from($loggedInUser->email);
            });
        }
    }

    private function setNewsStatusAccordingToLoggedInUser(News $news): void
    {
        $news->status = auth()->user()->isManager() ? NewsStatusDictionary::APPROVED : NewsStatusDictionary::PENDING_APPROVAL;
    }
}
