<?php

declare(strict_types=1);

namespace App\Policies;

use App\Data;
use App\Dictionaries\RoleDictionary;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DataPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->isManager()) {
            return true;
        }
    }

    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->role->name, [RoleDictionary::ROLE_MODERATOR]);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Data  $data
     * @return mixed
     */
    public function update(User $user, Data $data)
    {
        return $data->createdBy->is($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Data  $data
     * @return mixed
     */
    public function delete(User $user, Data $data)
    {
        return $data->createdBy->is($user);
    }

    public function approveData(User $user): bool
    {
        return $user->isManager();
    }

    public function rejectData(User $user): bool
    {
        return $user->isManager();
    }
}
