<?php


namespace core\useCases\auth;


use core\forms\auth\ResendVerificationEmailForm;
use core\helpers\tHelper;
use core\repositories\UserRepository;
use Yii;
use yii\mail\MailerInterface;

class EmailResendService
{
    private $mailer;
    private $users;

    public function __construct(UserRepository $users, MailerInterface $mailer)
    {
        $this->users = $users;
        $this->mailer = $mailer;
    }

    public function request(ResendVerificationEmailForm $form):void
    {
        $user = $this->users->getByEmail($form->email);
        $user->generateEmailVerificationToken();

        if ($user->isActive()){
            throw new \DomainException('User is active.');
        }

        $this->users->save($user);

        $sent = $this->mailer
            ->compose(['html' => 'auth/signup/emailVerify-html', 'text' => 'auth/signup/emailVerify-text'],
                ['user' => $user])
            ->setTo($user->email)
            ->setSubject(tHelper::translate('user/auth','email-title') . Yii::$app->name)
            ->send();

        if (!$sent) {
            throw new \RuntimeException('Sending error.');
        }
    }
}