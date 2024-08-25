<?php


namespace core\listeners\User;


use core\services\newsletter\Newsletter;
use core\useCases\auth\events\UserSignUpConfirmed;

class UserSignupConfirmedListener
{
    private $newsletter;

    public function __construct(Newsletter $newsletter)
    {
        $this->newsletter = $newsletter;
    }

    public function handle(UserSignUpConfirmed $event): void
    {
        $this->newsletter->subscribe($event->user->email);
    }
}