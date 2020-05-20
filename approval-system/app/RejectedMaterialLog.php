<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class RejectedMaterialLog extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function materialType()
    {
        return $this->belongsTo(MaterialType::class);
    }

    public static function createRejectedMaterialLog(Material $material)
    {
        $rejectedMaterialLog = new RejectedMaterialLog([
            'user_id' => $material->user->id,
            'type_id' => $material->type->id,
            'title' => $material->title,
            'content' => $material->content,
            'created_by' => auth()->user()->id,
        ]);

        $rejectedMaterialLog->save();
    }
}
