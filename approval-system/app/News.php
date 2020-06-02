<?php

namespace App;

use App\Dictionaries\NewsStatusDictionary;
use App\Observers\NewsObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class News extends Model
{
    protected $guarded = [];

    protected $observables = [
        'approved',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();
        News::observe(NewsObserver::class);
    }

    public function approve(): void
    {
        $this->status = NewsStatusDictionary::APPROVED;
        $this->save();

        $this->fireModelEvent('approved', false);
    }

    public static function createNewsByRequest(Request $request)
    {
        if ($request->hasFile('image'))
            $filename = self::storeNewsImage($request);

        return News::create([
            'title' => $request->get('title'),
            'image' => $filename ?? 'default.png',
            'description' => $request->get('description'),
        ]);
    }

    public function updateNewsByRequest(Request $request)
    {
        if ($request->hasFile('image'))
            $filename = self::storeNewsImage($request);

        $this->title = $request->get('title');
        $this->description = $request->get('description');
        $this->image = $filename ?? $this->image;

        $this->save();
    }


    private static function storeNewsImage(Request $request): string
    {
        $image = $request->image;
        $extension = $image->getClientOriginalExtension();
        $filename = (new \DateTime())->getTimestamp() . '-' .  uniqid() . '.' . $extension;
        $image->storeAs('public/images', $filename);
        return $filename;
    }
}
