<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'formatter' => [
            //'locale' => 'ru-RU',
            'defaultTimeZone' => 'Europe/Moscow',
            //'timeZone' => 'Europe/Moscow',
            //'dateFormat' => 'dd.MM.yyyy',
            //'timeFormat' => 'HH:mm:ss',
            //'datetimeFormat' => 'dd.MM.yyyy HH:mm:ss',
        ],
        'cache' => [
            //'class' => \yii\caching\FileCache::class,
            //'cachePath' => '@common/runtime/cache',
            'class' => \yii\caching\MemCache::class,
            'useMemcached' => true,
        ],
    ],
];
