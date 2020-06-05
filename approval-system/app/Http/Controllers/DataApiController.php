<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Data;
use App\Dictionaries\DataStatusDictionary;
use App\DTO\Data\DataDTO;
use App\DTO\ResponseData;
use App\Events\DataTransactionCompletedEvent;
use App\Http\Requests\CreateDataRequest;
use App\Services\DataManagerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DataApiController extends Controller
{
    /**
     * @var DataManagerService
     */
    private $dataManagerService;

    public function __construct(DataManagerService $dataManagerService)
    {
        $this->dataManagerService = $dataManagerService;
        $this->middleware('auth');
        $this->authorizeResource(Data::class, 'data');
    }

    public function store(CreateDataRequest $request)
    {
        $data = $this->dataManagerService->submitDataForApproval($request);

        return new ResponseData([
            'data' => DataDTO::fromModel($data),
        ]);
    }

    public function approve(Data $data)
    {
        $this->authorize('approveData', Data::class);

        abort_if(DataStatusDictionary::PENDING_APPROVAL !== $data->status, Response::HTTP_BAD_REQUEST);

        $this->dataManagerService->approveData($data);

        if ($data->shouldDispatchTransactionCompletedEvent())
            event(new DataTransactionCompletedEvent(json_decode($data->data, true)));

        return new JsonResponse(null, Response::HTTP_OK);
    }

    public function reject(Data $data)
    {
        $this->authorize('rejectData', Data::class);

        abort_if(DataStatusDictionary::PENDING_APPROVAL !== $data->status, Response::HTTP_BAD_REQUEST);

        $data->reject();
        $data->save();

        return new JsonResponse(null, Response::HTTP_OK);
    }
}
