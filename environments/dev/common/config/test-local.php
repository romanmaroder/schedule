<?php

return [
    'components' => [
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'mysql:host=localhost;dbname=schedule_test',
            'username' => 'root',
            'password' => ''
        ],
    ],
];
