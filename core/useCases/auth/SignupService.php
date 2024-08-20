<?php


namespace core\useCases\auth;


use core\entities\User\User;
use core\forms\auth\SignupForm;
use core\repositories\UserRepository;
use core\services\newsletter\Newsletter;
use Yii;
use yii\base\InvalidArgumentException;
use yii\mail\MailerInterface;

class SignupService
{
    private $mailer;
    private $users;
    private $newsletter;

    public function __construct(UserRepository $users,
        MailerInterface $mailer,
        /*Newsletter $newsletter*/
    )
    {
        $this->users = $users;
        $this->mailer = $mailer;
        /*$this->newsletter = $newsletter;*/
    }

    public function signup(SignupForm $form): void
    {
        $user = User::requestSignup(
            $form->username,
            $form->email,
            $form->password
        );

        $this->users->save($user);

        $sent = Yii::$app
            ->mailer
            ->compose(
                ['html' => 'auth/signup/emailVerify-html', 'text' => 'auth/signup/emailVerify-text'],
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

        $user = $this->users->getByVerificationToken($token);
        $user->verifyEmail();
        $this->users->save($user);

        /*Uncomment if you need a newsletter
        $this->newsletter->subscribe($user->email);
        */
    }
}