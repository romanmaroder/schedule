<?php

namespace core\entities\Enums;

enum UserStatusEnum: int
{
    case STATUS_DELETED = 0;

    case STATUS_INACTIVE = 9;

    case STATUS_ACTIVE = 10;

}
