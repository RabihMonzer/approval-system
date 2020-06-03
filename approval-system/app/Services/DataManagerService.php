<?php

declare(strict_types=1);

namespace App\Services;

use App\Data;
use App\Events\DataApprovedEvent;
use App\Http\Requests\CreateDataRequest;

class DataManagerService
{
    public function submitDataForApproval(CreateDataRequest $request)
    {
        return Data::createData($request);
    }

    public function approveData(Data $data): void
    {
        $data->approve();

        event(new DataApprovedEvent($data));
        $data->save();
    }
}
