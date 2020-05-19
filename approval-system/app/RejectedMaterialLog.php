<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class RejectedMaterialLog extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
