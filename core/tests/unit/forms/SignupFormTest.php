<?php

namespace core\tests\unit\forms;

use common\fixtures\UserFixture;
use core\forms\auth\SignupForm;

class SignupFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;


    public function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ]);
    }

    public function testCorrectSignup()
    {
        $model = new SignupForm([
            'username' => 'some_username',
            'email' => 'some_email@example.com',
            'password' => 'some_password',
        ]);

//        $user = $model->signup();
//        verify($user)->notEmpty();
//
//        /** @var \common\entities\User $user */
//        $user = $this->tester->grabRecord('common\entities\User', [
//            'username' => 'some_username',
//            'email' => 'some_email@example.com',
//            'status' => \common\entities\User::STATUS_INACTIVE
//        ]);
//
//        $this->tester->seeEmailIsSent();
//
//        $mail = $this->tester->grabLastSentEmail();
//
//        verify($mail)->instanceOf('yii\mail\MessageInterface');
//        verify($mail->getTo())->arrayHasKey('some_email@example.com');
//        verify($mail->getFrom())->arrayHasKey(\Yii::$app->params['supportEmail']);
//        verify($mail->getSubject())->equals('Account registration at ' . \Yii::$app->name);
//        verify($mail->toString())->stringContainsString($user->verification_token);
        verify($model->validate());
    }

    public function testNotCorrectSignup()
    {
        $model = new SignupForm([
            'username' => 'troy.becker',
            'email' => 'nicolas.dianna@hotmail.com',
            'password' => 'some_password',
        ]);

        //verify($model->signup())->empty();
        verify($model->validate());
        verify($model->getErrors('username'))->notEmpty();
        verify($model->getErrors('email'))->notEmpty();

        verify($model->getFirstError('username'))
            ->equals('This username has already been taken.');
        verify($model->getFirstError('email'))
            ->equals('This email address has already been taken.');
    }
}
