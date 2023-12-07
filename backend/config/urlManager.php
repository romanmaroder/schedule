<?php

/** @var array $params */

return [
    'class' => 'yii\web\UrlManager',
    'hostInfo' => $params['backendHostInfo'],
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        '' => 'site/index',
        '<_a:login|logout>' => 'auth/<_a>',

        'event' => 'schedule/event/index',
        'event/<id:\d+>' => 'schedule/event/view',
        'event/update/<id:\d+>' => 'schedule/event/update',
        'calendar' => 'schedule/calendar/calendar',

        'education' => 'schedule/education/index',
        'education/<id:\d+>' => 'schedule/education/view',
        'education/update/<id:\d+>' => 'schedule/education/update',

        
        '<_c:[\w\-]+>' => '<_c>/index',
        '<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
        '<_c:[\w\-]+>/<_a:[\w-]+>' => '<_c>/<_a>',
        '<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+>' => '<_c>/<_a>',
    ],
];