<?php

namespace App\Observers;

use App\Data;
use App\Dictionaries\DataStatusDictionary;

class DataObserver
{
    public function creating(Data $data)
    {
        $this->setNewsStatusAccordingToLoggedInUser($data);
        $data->created_by = auth()->user()->id;
    }

    public function updating(Data $data)
    {
        $this->setNewsStatusAccordingToLoggedInUser($data);
        $data->updated_by = auth()->user()->id;
    }

    private function setNewsStatusAccordingToLoggedInUser(Data $data): void
    {
        $data->status = auth()->user()->isManager() ? DataStatusDictionary::APPROVED : DataStatusDictionary::PENDING_APPROVAL;
    }
}
