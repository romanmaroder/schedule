<?php

namespace core\entities\Enums;

use core\helpers\tHelper;

enum ToolsEnum: int
{
    case TOOLS_ARE_NOT_READY = 0;
    case TOOLS_READY = 1;

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
            self::TOOLS_ARE_NOT_READY->value => 'badge badge-secondary',
            self::TOOLS_READY->value => 'badge badge-warning',
            default => 'badge bg-info',
        };
    }

    private static function translate( $enum): string
    {
        return match ($enum) {
            self::TOOLS_ARE_NOT_READY => tHelper::translate('schedule/event', 'TOOLS ARE NOT READY'),
            self::TOOLS_READY => tHelper::translate('schedule/event', 'TOOLS READY'),
            default => throw new \RuntimeException('Unknown status'),
        };
    }



}
