<?php

declare(strict_types=1);

namespace App;

use App\Dictionaries\MaterialStatusDictionary;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(MaterialType::class, 'type_id');
    }

    public function approve(): void
    {
        $this->status = MaterialStatusDictionary::APPROVED;
        $this->save();
    }
}
