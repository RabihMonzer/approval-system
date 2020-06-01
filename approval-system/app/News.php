<?php

namespace App;

use App\Dictionaries\NewsStatusDictionary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class News extends Model
{
    protected $guarded = [];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class);
    }

    public function approve(): void
    {
        $this->status = NewsStatusDictionary::APPROVED;
        $this->save();
    }

    public static function createNewsByRequest(Request $request)
    {
        if ($request->hasFile('image'))
            $filename = self::storeNewsImage($request);

        $user = auth()->user();

        return News::create([
            'created_by' => $user->id,
            'title' => $request->get('title'),
            'image' => $filename ?? 'default.png',
            'description' => $request->get('description'),
            'status' => $user->isManager() ? NewsStatusDictionary::APPROVED : NewsStatusDictionary::PENDING_APPROVAL
        ]);
    }

    public function updateNewsByRequest(Request $request)
    {
        if ($request->hasFile('image'))
            $filename = self::storeNewsImage($request);

        $user = auth()->user();

        $this->updated_by = $user->id;
        $this->title = $request->get('title');
        $this->description = $request->get('description');
        $this->status = $user->isManager() ? NewsStatusDictionary::APPROVED : NewsStatusDictionary::PENDING_APPROVAL;
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
