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

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public static function createRejectedMaterialLog(Material $material)
    {
        $rejectedMaterialLog = new RejectedMaterialLog([
            'user_id' => $material->user->id,
            'title' => $material->title,
            'content' => $material->content,
            'created_by' => auth()->user()->id,
        ]);

        $rejectedMaterialLog->save();

        return $rejectedMaterialLog;
    }
}
