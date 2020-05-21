<?php

declare(strict_types=1);

namespace App;

use App\Dictionaries\RoleDictionary;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function rejectedMaterialLogs()
    {
        return $this->hasMany(RejectedMaterialLog::class);
    }

    public function getMaterials(?string $status)
    {
        if ($this->isManager()) {
            return is_null($status) ? Material::orderByDesc('created_at')->get()
                : Material::where('status', '=', $status)->orderByDesc('created_at')->get();
        }

        return null === $status ?
            $this->materials()->orderByDesc('created_at')->get()
            : $this->materials()->where('status', '=', $status)->orderByDesc('created_at')->get();
    }

    private function filterMaterialsByStatus(Collection $materials, ?string $status)
    {

    }

    public function getRejectedMaterialsLog()
    {
        if ($this->isManager()) {
            return RejectedMaterialLog::orderByDesc('created_at')->get();
        }

        return $this->rejectedMaterialLogs()->orderByDesc('created_at')->get();
    }

    public function isManager(): bool
    {
        return RoleDictionary::ROLE_MANAGER === $this->role->name;
    }
}
