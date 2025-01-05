<?php

namespace core\entities\Enums;

use core\entities\Enums\Interface\UserEnumInterface;
use core\entities\Enums\Traits\UserEnumTrait;

enum EmployeeStatusEnum: int implements UserEnumInterface
{
    use UserEnumTrait;

    case STATUS_ACTIVE = 1;

    case STATUS_INACTIVE = 0;

}
