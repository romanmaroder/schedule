<?php

namespace core\entities\Enums;

use core\entities\Enums\Interface\UserEnumInterface;
use core\entities\Enums\Traits\UserStatusEnumTrait;

enum UserStatusEnum: int implements UserEnumInterface
{
    use UserStatusEnumTrait;

    case STATUS_ACTIVE = 10;

    case STATUS_INACTIVE = 9;

}
