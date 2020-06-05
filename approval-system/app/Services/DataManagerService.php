<?php

declare(strict_types=1);

namespace App\Services;

use App\Callback;
use App\Data;
use App\Events\DataApprovedEvent;
use App\Http\Requests\CreateDataRequest;

class DataManagerService
{
    public function submitDataForApproval(CreateDataRequest $request)
    {
        $data = Data::createData($request);

        if ($request->has('callback_function')) {
            Callback::createCallback($request->get('callback_function'), $data);
        }

        return $data;
    }

    public function approveData(Data $data): void
    {
        $data->approve();

        event(new DataApprovedEvent($data));
        $data->save();
    }
}
