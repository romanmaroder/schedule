<?php

return [
    'components' => [
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'mysql:host=localhost;dbname=schedule',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 0,
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'messageConfig' => [
                'from' => ['roma12041985@yandex.ru' => 'schedule']
            ],
            'transport' => [
                'scheme' => 'smtps',
                'host' => 'smtp.yandex.ru',
                'username' => 'roma12041985@yandex.ru',
                'password' => 'ghtewusddeyckiee', //password generated in the yandex ID interface
                'port' => 465,
                'encryption' => 'tls', // tls
                'streamOptions' => [
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false
                    ]
                ],
            ],
        ],
        'robokassa' => [
            'class' => '\robokassa\Merchant',
            'baseUrl' => 'https://auth.robokassa.ru/Merchant/Index.aspx',
            'sMerchantLogin' => '',
            'sMerchantPass1' => '',
            'sMerchantPass2' => '',
        ],
    ],
];
