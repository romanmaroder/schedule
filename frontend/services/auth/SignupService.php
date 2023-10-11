<?php


namespace frontend\services\auth;


use common\entities\User;
use frontend\forms\SignupForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\mail\MailerInterface;

class SignupService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function signup(SignupForm $form): void
    {
        $user = User::requestSignup(
            $form->username,
            $form->email,
            $form->password
        );

        $this->save($user);

        $sent = Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setTo($user->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();

        if (!$sent) {
            throw new \RuntimeException('Email sending error.');
        }


    }

    public function confirm($token): void
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('Verify email token cannot be blank.');
        }

        $user = $this->findByVerificationToken($token);
        $user->verifyEmail();
        $this->save($user);

    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return User
     */
    private static function findByVerificationToken(string $token): User
    {
        if (!$user = User::findOne([
            'verification_token' => $token,
            'status' => User::STATUS_INACTIVE
        ])) {
            throw new \DomainException('User is not found.');
        }
        return $user;
    }

    /**
     * @param User $user
     */
    private function save(User $user): void
    {
        if (!$user->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }
}