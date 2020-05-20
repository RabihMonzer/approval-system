<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialType extends Model
{
    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function rejectedMaterialLogs()
    {
        return $this->hasMany(RejectedMaterialLog::class);
    }
}
