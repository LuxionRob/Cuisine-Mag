<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

final class UserRole extends Enum
{
    const ROLE_ADMIN = 'ADMIN';
    const ROLE_USER = 'USER';
    const ROLE_SALESMAN = 'SALESMAN';
    public static $types = [self::ROLE_ADMIN, self::ROLE_USER, self::ROLE_SALESMAN];
}
