<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'bootstrap' => [
        'queue',
    ],
    'sourceLanguage' => 'en',
    'language' => 'ru-Ru',
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
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => '{{%auth_items}}',
            'itemChildTable' => '{{%auth_item_children}}',
            'assignmentTable' => '{{%auth_assignments}}',
            'ruleTable' => '{{%auth_rules}}',
        ],
        'queue' => [
            'class' => 'yii\queue\redis\Queue',
            'as log' => 'yii\queue\LogBehavior',
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app/app.php',
                        'app/error' => 'error.php',
                    ],
                ],
                'blog*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'blog' => 'blog/blog.php',
                        'blog/tag' => 'blog/tag.php',
                        'blog/category' => 'blog/category.php',
                        'blog/comments' => 'blog/comments.php',
                    ],
                ],
                'schedule*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'schedule/service' => 'schedule/service/service.php',
                        'schedule/service/tag' => 'schedule/service/tag.php',
                        'schedule/service/price' => 'schedule/service/price.php',
                        'schedule/service/category' => 'schedule/service/category.php',
                        'schedule/additional' => 'schedule/additional/additional.php',
                        'schedule/additional/category' => 'schedule/additional/category.php',
                        'schedule/free' => 'schedule/free/free.php',
                        'schedule/education' => 'schedule/education/education.php',
                        'schedule/calendar' => 'schedule/calendar/calendar.php',
                        'schedule/event' => 'schedule/event/event.php',
                        'schedule/event/service' => 'schedule/event/service.php',
                    ],
                ],
                'shop*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'shop' => 'shop/shop.php',
                        'shop/tag' => 'shop/tag/tag.php',
                        'shop/brand' => 'shop/brand/brand.php',
                        'shop/characteristic' => 'shop/characteristic/characteristic.php',
                        'shop/delivery' => 'shop/delivery/delivery.php',
                        'shop/order' => 'shop/order/order.php',
                        'shop/customer' => 'shop/customer/customer.php',
                        'shop/review' => 'shop/review/review.php',
                        'shop/product' => 'shop/product/product.php',
                        'shop/category' => 'shop/category/category.php',
                    ],
                ],
                'expenses*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'expenses' => 'expenses/expenses.php',
                        'expenses/category' => 'expenses/category.php',
                        'expenses/tag' => 'expenses/tag.php',
                    ],
                ],
                'user*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'user' => 'user/user.php',
                        'user/employee' => 'user/employee.php',
                        'user/schedule' => 'user/schedule.php',
                        'user/address' => 'user/address.php',
                    ],
                ],
                'product*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'product' => 'product/product.php',
                        'product/order' => 'product/order.php',
                    ],
                ],
                'role*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'role' => 'role/role.php',
                    ],
                ],
                'rate*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'rate' => 'rate/rate.php',
                    ],
                ],
                'price*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'price' => 'price/price.php',
                        'price/category' => 'price/category.php',
                    ],
                ],
                'content*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'content/page' => 'content/page/page.php',
                        'content/file' => 'content/file/file.php',
                    ],
                ],
                'meta' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'meta' => 'meta/meta.php',
                    ],
                ],
                'navbar*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'navbar' => 'navbar/navbar.php',
                    ],
                ],
            ],
        ],
    ],
];
