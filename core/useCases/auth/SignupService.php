<?php


namespace core\useCases\auth;


use core\dispatchers\EventDispatcher;
use core\entities\User\User;
use core\forms\auth\SignupForm;
use core\repositories\UserRepository;
use core\services\newsletter\Newsletter;
use core\services\TransactionManager;
use core\useCases\auth\events\UserSignUpConfirmed;
use core\useCases\auth\events\UserSignUpRequested;
use Yii;
use yii\base\InvalidArgumentException;
use yii\mail\MailerInterface;

class SignupService
{
    private $mailer;
    private $users;
    private $newsletter;
    private $dispatcher;

    public function __construct(UserRepository $users,
        MailerInterface $mailer,
        TransactionManager $transaction,
        /*Newsletter $newsletter*/
        EventDispatcher $dispatcher
    )
    {
        $this->users = $users;
        $this->mailer = $mailer;
        $this->transaction = $transaction;
        /*$this->newsletter = $newsletter;*/
        $this->dispatcher = $dispatcher;
    }

    public function signup(SignupForm $form): void
    {
        $user = User::requestSignup(
            $form->username,
            $form->email,
            $form->password
        );

        $this->transaction->wrap(function () use ($user) {
            $this->users->save($user);
        });

        $this->dispatcher->dispatch(new UserSignUpRequested($user));


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

        $this->dispatcher->dispatch(new UserSignUpConfirmed($user));

        /*Uncomment if you need a newsletter
        $this->newsletter->subscribe($user->email);
        */
    }
}