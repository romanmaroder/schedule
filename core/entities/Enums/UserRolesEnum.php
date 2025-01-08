<?php

namespace core\entities\Enums;

use core\helpers\tHelper;

enum UserRolesEnum: string
{
    case ROLE_EMPLOYEE = 'employee';
    case ROLE_MANAGER = 'manager';
    case ROLE_ADMIN = 'admin';

    //case PERMISSION_EMPLOYEE = 'Permission_employee';
   //case PERMISSION_MANAGER = 'Permission_manager';
    //case PERMISSION_ADMIN = 'Permission_admin';

    public static function getList(): array
    {
        $res = [];
        foreach (self::cases() as $case) {
            $res[$case->value] = self::translate($case);
        }
        return $res;
    }

    public static function getBadge($enum): string
    {
        return match ($enum) {
            self::ROLE_ADMIN->value => 'badge bg-danger bg-gradient box-shadow',
            self::ROLE_MANAGER->value => 'badge bg-warning bg-gradient box-shadow',
            self::ROLE_EMPLOYEE->value => 'badge bg-info bg-gradient box-shadow',
            default => 'badge bg-secondary',
        };
    }

    private static function translate( $enum): string
    {
        return match ($enum) {
            self::ROLE_ADMIN => tHelper::translate('role', 'admin'),
            self::ROLE_EMPLOYEE => tHelper::translate('role', 'employee'),
            self::ROLE_MANAGER => tHelper::translate('role', 'manager'),
            default => throw new \RuntimeException('Unknown status'),
        };
    }
}
