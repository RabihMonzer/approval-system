<?php

declare(strict_types=1);

namespace App;

use App\Dictionaries\RoleDictionary;
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

    public function news()
    {
        return $this->hasMany(News::class, 'created_by');
    }

    public function submittedData()
    {
        return $this->hasMany(Data::class, 'created_by');
    }

    public function rejectedNewsLogs()
    {
        return $this->hasMany(RejectedNewsLog::class, 'owner_id');
    }

    public function getNewsByStatus(?string $status)
    {
        if ($this->isManager()) {
            return is_null($status) ? News::orderByDesc('created_at')->get()
                : News::where('status', '=', $status)->orderByDesc('created_at')->get();
        }

        return null === $status ?
            $this->news()->orderByDesc('created_at')->get()
            : $this->news()->where('status', '=', $status)->orderByDesc('created_at')->get();
    }

    public function getRejectedNewsLogs()
    {
        if ($this->isManager()) {
            return RejectedNewsLog::orderByDesc('created_at')->get();
        }

        return $this->rejectedNewsLogs()->orderByDesc('created_at')->get();
    }

    public function isManager(): bool
    {
        return RoleDictionary::ROLE_MANAGER === $this->role->name;
    }
}
