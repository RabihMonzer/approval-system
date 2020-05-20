<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function materialType()
    {
        return $this->belongsTo(MaterialType::class, 'type_id');
    }
}
