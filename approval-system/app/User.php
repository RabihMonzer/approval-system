<?php

declare(strict_types=1);

namespace App;

use App\Dictionaries\RoleDictionary;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

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

    public function getMaterials()
    {
        if ($this->isManager()) {
            return Material::orderByDesc('created_at')->get();
        }

        return $this->materials()->orderByDesc('created_at')->get();
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
