<?php

namespace App\Models;

enum RoleType: int
{
    case ADMIN = 1;
    case USER = 2;
    case ImportStaff = 3;
    case HR = 4;
}
