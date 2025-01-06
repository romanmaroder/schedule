<?php

namespace core\entities\Enums;

use core\entities\Enums\Interface\UserEnumInterface;
use core\entities\Enums\Traits\UserRolesEnumTrait;

enum UserRolesEnum: string implements UserEnumInterface
{
    use UserRolesEnumTrait;
    case ROLE_EMPLOYEE = 'employee';
    case ROLE_MANAGER = 'manager';
    case ROLE_ADMIN = 'admin';

    //case PERMISSION_EMPLOYEE = 'Permission_employee';
   //case PERMISSION_MANAGER = 'Permission_manager';
    //case PERMISSION_ADMIN = 'Permission_admin';
}
