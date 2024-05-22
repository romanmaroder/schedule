<?php

use yii\log\FileTarget;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@staticRoot' => $params['staticPath'],
        '@static'   => $params['staticHostInfo'],
    ],
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => [
        'log',
        'common\bootstrap\SetUp',
        'backend\bootstrap\SetUp',
    ],
    'modules' => [],
    'controllerMap' => [
        'elfinder' => [
            'class' => 'mihaildev\elfinder\Controller',
            'access' => ['@'],
            'plugin' => [
                [
                    'class'=>'\mihaildev\elfinder\plugin\Sluggable',
                    'lowercase' => true,
                    'replacement' => '-'
                ]
            ],
            'roots' => [
                [
                    'baseUrl'=>'@static',
                    'basePath'=>'@staticRoot',
                    'path' => 'files',
                    'name' => 'Global'
                ],
            ],
        ],
    ],
    'components' => [
        'request' => [
            'baseUrl' => '',
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'schedule\entities\User\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'loginUrl' => ['auth/login'],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'backendUrlManager' => require __DIR__ . '/urlManager.php',
        'frontendUrlManager' => require __DIR__ . '/../../frontend/config/urlManager.php',
        'urlManager' => function () {
            return Yii::$app->get('backendUrlManager');
        },
    ],
    'as access' => [
        'class' => 'yii\filters\AccessControl',
        'except' => ['auth/login','auth/logout','site/error'],
        'rules' => [
            [
                'allow' => true,
                'roles' => ['permission_admin','permission_manager'],
            ],
        ],
    ],
    'params' => $params,
];
