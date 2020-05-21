<?php

declare(strict_types=1);

namespace App;

use App\Dictionaries\MaterialStatusDictionary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Material extends Model
{
    protected $guarded = [];

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

    public static function createNewMaterialByRequest(Request $request, MaterialType $materialType): Material
    {
        $user = auth()->user();

        return Material::create([
            'user_id' => $user->id,
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'type_id' => $materialType->id,
            'status' => $user->isManager() ? MaterialStatusDictionary::APPROVED : MaterialStatusDictionary::PENDING_APPROVAL
        ]);
    }
}
