<?php


namespace common\bootstrap;


use core\cart\schedule\Cart;
use core\cart\schedule\storage\DbStorage;
use core\cart\shop\Cart as ShopCart;
use core\cart\shop\cost\calculator\DynamicCost;
use core\cart\shop\cost\calculator\SimpleCost;
use core\cart\shop\storage\HybridStorage;
use core\dispatchers\EventDispatcher;
use core\dispatchers\SimpleEventDispatcher;
use core\listeners\User\UserSignupConfirmedListener;
use core\listeners\User\UserSignupRequestedListener;
use core\services\shop\yandex\ShopInfo;
use core\services\shop\yandex\YandexMarket;
use core\services\sms\simpleSms\SimpleSms;
use core\services\sms\simpleSms\SmsMessage;
use core\services\sms\simpleSms\SmsOs;
use core\services\sms\SmsSender;
use core\useCases\auth\events\UserSignUpConfirmed;
use core\useCases\auth\events\UserSignUpRequested;
use core\useCases\auth\SignupService;
use core\useCases\ContactService;
use yii\base\BootstrapInterface;
use yii\caching\Cache;
use yii\di\Container;
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

        $container->setSingleton(Cart::class, function () use ($app) {
            return new Cart(
                new DbStorage($app->get('user') ,$app->db)
            //new HybridStorage($app->get('user'), 'cart', 3600 * 24, $app->db),
            //new DynamicCost(new SimpleCost())
            );
        });

        $container->setSingleton(
            ShopCart::class, function () use ($app) {
            return new ShopCart(
                new HybridStorage($app->get('user'), 'cart', 3600 * 24, $app->db),
                new DynamicCost(new SimpleCost())
            );
        });

        $container->setSingleton(YandexMarket::class, [], [
            new ShopInfo($app->name, $app->name, $app->params['shopHostInfo']),
        ]);

        /*$container->setSingleton(Newsletter::class, function () use ($app) {
           return new MailChimp(
               new \DrewM\MailChimp\MailChimp($app->params['mailChimpKey']),
               $app->params['mailChimpListId']
           );
       });*/

        /*$container->setSingleton(ShopSmsSender::class, function () use ($app) {
            return new LoggedSender(
                new SmsRu($app->params['smsRuKey']),
                \Yii::getLogger()
            );
        });*/

        $container->setSingleton(
            SmsSender::class,
            function () use ($app) {
                return new SimpleSms(
                    new SmsOs(),
                    new SmsMessage()
                );
            }
        );

        $container->setSingleton(
            EventDispatcher::class,
            function (Container $container) {
                return new SimpleEventDispatcher(
                    [
                        UserSignUpRequested::class => [
                            [$container->get(UserSignupRequestedListener::class), 'handle'],
                        ],
                        /*UserSignUpConfirmed::class => [
                            [$container->get(UserSignupConfirmedListener::class), 'handle'],
                        ],*/
                    ]
                );
            }
        );
    }
}
