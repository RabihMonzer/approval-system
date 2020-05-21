<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialType extends Model
{
    protected $guarded = [];

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function rejectedMaterialLogs()
    {
        return $this->hasMany(RejectedMaterialLog::class);
    }

    public static function getMaterialType(string $materialType): ?MaterialType
    {
        return MaterialType::where('type', '=', $materialType)->get()->first();
    }

    public static function createMaterialType(string $materialType): MaterialType
    {
        return MaterialType::create(['type' => $materialType]);
    }
}
