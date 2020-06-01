<?php

declare(strict_types=1);

namespace App\Validators;

use App\Dictionaries\RoleDictionary;
use Illuminate\Http\Response;

trait UserRoleValidatorTrait
{
    public function abortUnlessUserIsManager(): void
    {
        if (!auth()->user()->isManager()) {
            abort(Response::HTTP_FORBIDDEN);
        }
    }

    public function abortUnlessUserHasPermission(): void
    {
        if (!in_array(auth()->user()->role->name, [RoleDictionary::ROLE_MANAGER, RoleDictionary::ROLE_MODERATOR])) {
            abort(Response::HTTP_FORBIDDEN);
        }
    }
}
