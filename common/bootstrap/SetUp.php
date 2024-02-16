<?php


namespace common\bootstrap;


use schedule\cart\Cart;
use schedule\cart\storage\DbStorage;
use schedule\services\auth\SignupService;
use schedule\services\ContactService;
use yii\base\BootstrapInterface;
use yii\caching\Cache;
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
        $container->setSingleton(Cache::class,function () use ($app){
            return $app->cache;
        });
        $container->setSingleton(SignupService::class);
        $container->setSingleton(ContactService::class, [], [
            $app->params['adminEmail']
        ]);
        $container->setSingleton(Cart::class, function () use ($app) {
            return new Cart(
                new DbStorage($app->get('user') ,$app->db)
                //new HybridStorage($app->get('user'), 'cart', 3600 * 24, $app->db),
                //new DynamicCost(new SimpleCost())
            );
        });
    }
}
