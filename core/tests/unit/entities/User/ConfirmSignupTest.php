<?php


namespace core\tests\unit\entities\User;


use Codeception\Test\Unit;
use core\entities\Enums\StatusEnum;
use core\entities\User\User;

class ConfirmSignupTest extends Unit
{
    public function testSuccess()
    {
        $user = new User([
            'status' => StatusEnum::STATUS_INACTIVE,
            'verification_token' => 'token',
        ]);

        $user->verifyEmail();

        $this->assertEmpty($user->verification_token);
        $this->assertFalse($user->isInactive());
        $this->assertTrue($user->isActive());
    }

    public function testAlreadyActive()
    {
        $user = new User([
            'status' => StatusEnum::STATUS_ACTIVE,
            'verification_token' => null,
        ]);

        $this->expectExceptionMessage('User is already active.');

        $user->verifyEmail();
    }
}