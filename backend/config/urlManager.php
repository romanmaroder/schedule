<?php

/** @var array $params */

return [
    'class' => 'yii\web\UrlManager',
    'hostInfo' => $params['backendHostInfo'],
    'baseUrl' => '',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'cache' => false,
    'rules' => [
        '' => 'site/index',
        '<_a:login|logout>' => 'auth/<_a>',

        'event' => 'schedule/event/index',
        'event/m' => 'schedule/event/m',
        'event/<id:\d+>' => 'schedule/event/view',
        'event/update/<id:\d+>' => 'schedule/event/update',
        'event/history/<id:\d+>' => 'schedule/api/event-api/history',
        'calendar' => 'schedule/calendar/calendar',

        'education' => 'schedule/education/index',
        'education/<id:\d+>' => 'schedule/education/view',
        'education/update/<id:\d+>' => 'schedule/education/update',

        'free' => 'schedule/free-time/index',
        'free/<id:\d+>' => 'schedule/free-time/view',
        'free/update/<id:\d+>' => 'schedule/free-time/update',

        'missing'=>'schedule/missing-users/index',

        'cabinet' => 'cabinet/default/index',
        'cabinet/<_c:[\w\-]+>' => 'cabinet/<_c>/index',
        'cabinet/<_c:[\w\-]+>/<id:\d+>' => 'cabinet/<_c>/view',
        'cabinet/<_c:[\w\-]+>/<_a:[\w-]+>' => 'cabinet/<_c>/<_a>',
        'cabinet/<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+>' => 'cabinet/<_c>/<_a>',
        
        '<_c:[\w\-]+>' => '<_c>/index',
        '<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
        '<_c:[\w\-]+>/<_a:[\w-]+>' => '<_c>/<_a>',
        '<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+>' => '<_c>/<_a>',
    ],
];