<?php

declare(strict_types=1);

namespace App\DTO\Material;

use App\DTO\ModelDTOInterface;
use App\Material;
use Spatie\DataTransferObject\DataTransferObject;

class MaterialDTO extends DataTransferObject implements ModelDTOInterface
{
    /** @var int */
    public $id;

    /** @var string */
    public $title;

    /** @var string */
    public $content;

    /** @var string */
    public $status;

    /** @var \DateTime|null */
    public $created_at;

    /** @var \DateTime|null */
    public $updated_at;

    public static function fromModel(Material $material): MaterialDTO
    {
        return new static([
            'id' => $material->id,
            'title' => $material->title,
            'content' => $material->content,
            'status' => $material->status,
            'created_at' => $material->created_at,
            'updated_at' => $material->updated_at,
        ]);
    }
}
