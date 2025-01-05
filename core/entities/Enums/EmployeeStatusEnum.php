<?php

namespace core\entities\Enums;

use core\entities\Enums\Interface\UserEnumInterface;
use core\entities\Enums\Traits\UserStatusEnumTrait;

enum EmployeeStatusEnum: int implements UserEnumInterface
{
    use UserStatusEnumTrait;

    case STATUS_ACTIVE = 1;

    case STATUS_INACTIVE = 0;

}
