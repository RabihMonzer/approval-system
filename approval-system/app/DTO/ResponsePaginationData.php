<?php

declare(strict_types=1);

namespace App\DTO;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\DataTransferObject;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class ResponsePaginationData extends DataTransferObject implements Responsable
{
    public $collection;

    /** @var int  */
    public $status = 200;

    /**
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function toResponse($request)
    {
        return response()->json(
            [
                'data' => $this->collection->toArray(),
            ],
            $this->status
        );
    }
}
