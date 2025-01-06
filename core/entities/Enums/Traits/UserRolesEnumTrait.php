<?php

namespace core\entities\Enums\Traits;

use core\entities\Enums\Interface\UserEnumInterface;
use core\helpers\tHelper;

trait UserRolesEnumTrait
{
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

    private static function translate(UserEnumInterface $enum): string
    {
        return match ($enum) {
            self::ROLE_ADMIN => tHelper::translate('role', 'admin'),
            self::ROLE_EMPLOYEE => tHelper::translate('role', 'employee'),
            self::ROLE_MANAGER => tHelper::translate('role', 'manager'),
            default => throw new \RuntimeException('Unknown status'),
        };
    }

}