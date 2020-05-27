<?php

declare(strict_types=1);

namespace App\DTO;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\DataTransferObjectCollection;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class ResponseData extends DataTransferObject implements Responsable
{
    public $status = 200;

//    /** @var DataTransferObject|DataTransferObjectCollection */
    public $data;

    /**
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function toResponse($request)
    {
        return response()->json(
            [
                'data' => $this->data->toArray(),
            ],
            $this->status
        );
    }
}
