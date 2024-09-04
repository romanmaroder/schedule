<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'shop',
    'name'=>'Yebuchacha',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'common\bootstrap\SetUp',
    ],
    'aliases' => [
        '@staticRoot' => $params['staticPath'],
        '@static'   => $params['staticHostInfo'],
    ],
    'controllerNamespace' => 'shop\controllers',
    'components' => [
        'request' => [
            'baseUrl' => '',
            'csrfParam' => '_csrf-shop',
        ],
        'user' => [
            'identityClass' => 'common\auth\Identity',
            'enableAutoLogin' => false,
            'identityCookie' => ['name' => '_identity-shop', 'httpOnly' => true],
            'loginUrl' => ['auth/auth/login'],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the shop
            'name' => 'advanced-shop',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'backendUrlManager' => require __DIR__ . '/../../backend/config/urlManager.php',
        'frontendUrlManager' => require __DIR__ . '/../../frontend/config/urlManager.php',
        'shopUrlManager' => require __DIR__ . '/urlManager.php',
        'urlManager' => function () {
            return Yii::$app->get('shopUrlManager');
        },

    ],
    /*'as access' => [
        'class' => 'yii\filters\AccessControl',
        'except' => [
            'auth/auth/login',
            'auth/auth/logout',
            'auth/resend/resend-verification-email',
            'auth/reset/reset-password',
            'auth/reset/request-password-reset',
            'site/error'
        ],
        'rules' => [
            [
                'allow' => true,
                'roles' => ['@'],

            ],
        ],

    ],*/
    'params' => $params,
];
