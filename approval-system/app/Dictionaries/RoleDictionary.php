<?php

namespace App\Dictionaries;

final class RoleDictionary
{
    const ROLE_MODERATOR = 'Moderator';
    const ROLE_MANAGER = 'Manager';

    public static function getValidRoleStatuses(): array
    {
        return [
            self::ROLE_MODERATOR,
            self::ROLE_MANAGER
        ];
    }
}
