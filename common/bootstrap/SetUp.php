<?php


namespace common\bootstrap;


use schedule\services\auth\SignupService;
use schedule\services\ContactService;
use yii\base\BootstrapInterface;
use yii\mail\MailerInterface;

class SetUp implements BootstrapInterface
{

    /**
     * @inheritDoc
     */
    public function bootstrap($app): void
    {
        $container = \Yii::$container;

        $container->setSingleton(MailerInterface::class, function () use ($app){
            return $app->mailer;
        });
        $container->setSingleton(SignupService::class);
        $container->setSingleton(ContactService::class, [], [
            $app->params['adminEmail']
        ]);
    }
}
