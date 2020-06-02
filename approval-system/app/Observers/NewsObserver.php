<?php

declare(strict_types=1);

namespace App\Observers;

use App\Dictionaries\NewsStatusDictionary;
use App\News;

class NewsObserver
{
    public function creating(News $news)
    {
        $news->status = auth()->user()->isManager() ? NewsStatusDictionary::APPROVED : NewsStatusDictionary::PENDING_APPROVAL;
        $news->created_by = auth()->user()->id;
    }

    public function updating(News $news)
    {
        $news->status = auth()->user()->isManager() ? NewsStatusDictionary::APPROVED : NewsStatusDictionary::PENDING_APPROVAL;
        $news->updated_by = auth()->user()->id;
    }
}
