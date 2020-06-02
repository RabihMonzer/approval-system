<?php

declare(strict_types=1);

namespace App\Observers;

use App\Dictionaries\NewsStatusDictionary;
use App\News;

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

    private function setNewsStatusAccordingToLoggedInUser(News $news): void
    {
        $news->status = auth()->user()->isManager() ? NewsStatusDictionary::APPROVED : NewsStatusDictionary::PENDING_APPROVAL;
    }
}
