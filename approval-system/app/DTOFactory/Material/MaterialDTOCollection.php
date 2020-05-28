<?php

declare(strict_types=1);

namespace App\DTOFactory\Material;

use App\DTO\Material\MaterialDTO;
use App\Material;
use Illuminate\Database\Eloquent\Collection;
use Spatie\DataTransferObject\DataTransferObjectCollection;

class MaterialDTOCollection extends DataTransferObjectCollection
{
    public function current(): MaterialDTO
    {
        return parent::current();
    }

    /**
     * @param Collection $data
     * @return MaterialDTOCollection
     */
    public static function fromCollection(Collection $data): MaterialDTOCollection
    {
        return new static(
            $data->map(function (Material $item) {
                return MaterialDTO::fromModel($item);
            })->toArray()
        );
    }
}
