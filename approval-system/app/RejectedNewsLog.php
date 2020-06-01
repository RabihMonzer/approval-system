<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RejectedNewsLog extends Model
{
    protected $guarded = [];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function rejectedBy()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    public static function createRejectedNewsLog(News $news): RejectedNewsLog
    {
        $rejectedNewsLogs = new RejectedNewsLog([
            'title' => $news->title,
            'description' => $news->description,
            'image' => $news->image,
            'owner_id' => $news->createdBy->id,
            'rejected_by' => auth()->user()->id,
        ]);

        $rejectedNewsLogs->save();

        return $rejectedNewsLogs;
    }
}
