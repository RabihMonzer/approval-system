<?php

declare(strict_types=1);

namespace App\DTO\RejectedMaterialLog;

use App\DTO\ModelDTOInterface;
use App\RejectedMaterialLog;
use Spatie\DataTransferObject\DataTransferObject;

class RejectedMaterialLogDTO extends DataTransferObject implements ModelDTOInterface
{
    /** @var int */
    public $id;

    /** @var string */
    public $title;

    /** @var string */
    public $content;

    /** @var \DateTime|null */
    public $created_at;

    /** @var \DateTime|null */
    public $updated_at;

    public static function fromModel(RejectedMaterialLog $rejectedMaterialLog): RejectedMaterialLogDTO
    {
        return new static([
            'id' => $rejectedMaterialLog->id,
            'title' => $rejectedMaterialLog->title,
            'content' => $rejectedMaterialLog->content,
            'created_at' => $rejectedMaterialLog->created_at,
            'updated_at' => $rejectedMaterialLog->updated_at,
        ]);
    }
}
