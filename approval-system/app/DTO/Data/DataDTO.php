<?php

declare(strict_types=1);

namespace App\DTO\Data;

use App\Data;
use Spatie\DataTransferObject\DataTransferObject;

class DataDTO extends DataTransferObject
{
    /** @var int */
    public $id;

    /** @var string */
    public $status;

    /** @var \DateTime|null */
    public $created_at;

    /** @var \DateTime|null */
    public $updated_at;

    /** @var string */
    public $transaction_type;

    public static function fromModel(Data $data): DataDTO
    {
        return new static([
            'id' => $data->id,
            'status' => $data->status,
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at,
            'transaction_type' => $data->transaction_type,
        ]);
    }
}
