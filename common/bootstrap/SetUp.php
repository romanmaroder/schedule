<?php


namespace common\bootstrap;


use core\cart\shop\Cart;
use core\cart\shop\cost\calculator\SimpleCost;
use core\cart\shop\storage\SessionStorage;
use core\cart\storage\DbStorage;
use core\services\auth\SignupService;
use core\services\ContactService;
use yii\base\BootstrapInterface;
use yii\caching\Cache;
use yii\mail\MailerInterface;
use yii\rbac\ManagerInterface;

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
        $container->setSingleton(Cache::class,function () use ($app){
            return $app->cache;
        });
        $container->setSingleton(SignupService::class);
        $container->setSingleton(ManagerInterface::class, function () use ($app) {
            return $app->authManager;
        });
        $container->setSingleton(ContactService::class, [], [
            $app->params['adminEmail']
        ]);

        $container->setSingleton(Cart::class, function () {
            return new Cart(
                new SessionStorage('cart'),
                new SimpleCost()
            );
        });

    }
}
