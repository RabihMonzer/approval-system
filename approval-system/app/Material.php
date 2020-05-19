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
}
