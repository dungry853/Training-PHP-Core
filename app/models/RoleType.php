<?php

namespace App\Models;

enum RoleType: int
{

    case ADMIN = 1;
    case USER = 2;
    case ImportStaff = 3;
    case HR = 4;

    public static function allCases(): array
    {
        return [
            self::ADMIN->value,
            self::ImportStaff->value,
            self::HR->value,
            self::USER->value,
        ];
    }

    public static function getAdminStaff(): array
    {
        return [
            self::ADMIN->value,
            self::ImportStaff->value,
            self::HR->value,
        ];
    }
}
