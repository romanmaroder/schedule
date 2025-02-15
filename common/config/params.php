<?php
return [
    'adminEmail' => 'admin@example.com',
    //'supportEmail' => 'support@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'user.passwordResetTokenExpire' => 3600,
    'user.rememberMeDuration' => 3600 * 24 * 30,
    'user.passwordMinLength' => 8,
    'frontendHostInfo' => 'http://example.com',
    'backendHostInfo' => 'http://backend.example.com',
    'staticHostInfo' => 'http://static.example.com',
    'staticPath' => dirname(__DIR__, 2) . '/static',
    /*'mailChimpKey' => '',
    'mailChimpListId' => '',
     'smsRuKey' => '',*/
    'hail812/yii2-adminlte3' => [
        'pluginMap' => [
            'datatables'                    => [
                'js' => 'datatables/jquery.dataTables.min.js'
            ],
            'bs-custom-file-input'          => [
                'js' => 'bs-custom-file-input/bs-custom-file-input.min.js'
            ],
            'datatables-bs4'                => [
                'css' => 'datatables-bs4/css/dataTables.bootstrap4.min.css',
                'js'  => 'datatables-bs4/js/dataTables.bootstrap4.min.js'
            ],
            'datatables-responsive'         => [
                'css' => 'datatables-responsive/css/responsive.bootstrap4.min.css',
                'js'  => [
                    'datatables-responsive/js/dataTables.responsive.min.js',
                    'datatables-responsive/js/responsive.bootstrap4.min.js'
                ]
            ],
            'datatables-buttons' => [
                'css' => 'datatables-buttons/css/buttons.bootstrap4.min.css',
                'js' => [
                    'datatables-buttons/js/dataTables.buttons.min.js',
                    'datatables-buttons/js/buttons.bootstrap4.min.js',
                    'datatables-buttons/js/buttons.colVis.min.js',
                    'datatables-buttons/js/buttons.flash.min.js',
                    'datatables-buttons/js/buttons.html5.min.js',
                    'datatables-buttons/js/buttons.print.min.js',
                ]
            ],
            'datatables-colreorder' => [
                'css' => 'datatables-colreorder/css/colReorder.bootstrap4.min.css',
                'js' => [
                    'datatables-colreorder/js/colReorder.bootstrap4.min.js',
                    'datatables-colreorder/js/dataTables.colReorder.min.js'
                ]
            ],
            'datatables-searchbuilder' => [
                'css' => 'datatables-searchbuilder/css/searchBuilder.bootstrap4.min.css',
                'js' => [
                    'datatables-searchbuilder/js/dataTables.searchBuilder.min.js',
                    'datatables-searchbuilder/js/searchBuilder.bootstrap4.min.js'
                ]
            ],
            'datatables-fixedheader' => [
                'css' => 'datatables-fixedheader/css/fixedHeader.bootstrap4.min.css',
                'js' => [
                    'datatables-fixedheader/js/dataTables.fixedHeader.min.js',
                    'datatables-fixedheader/js/fixedHeader.bootstrap4.min.js'
                ]
            ],
            'sweetalert2-theme-bootstrap-4' => [
                'css' => 'sweetalert2-theme-bootstrap-4/bootstrap-4.min.css'
            ],
            'sweetalert2' => [
                'js' => ['sweetalert2/sweetalert2.all.min.js']
            ],
            'toastr' => [
                'css' => ['toastr/toastr.min.css'],
                'js' => ['toastr/toastr.min.js'],
            ],
            /*'icheck-bootstrap' => [
                'css' => 'icheck-bootstrap.css'
            ],*/
            /*'ekko-lightbox'                 => [
                'css' => 'ekko-lightbox/ekko-lightbox.css',
                'js'  => 'ekko-lightbox/ekko-lightbox.min.js'
            ],
            'filterizr'                     => [
                'js' => 'filterizr/jquery.filterizr.min.js'
            ],*/
            /*'summernote'=>[
                'css'=>'summernote/summernote-bs4.min.css',
                'js'=>[
                    'summernote/summernote-bs4.min.js',
                    'summernote/lang/summernote-ru-Ru.js'
                ]
            ],
            'codemirror'=>[
                'css'=>[
                    'codemirror/codemirror.css',
                    'codemirror/theme/monokai.css',
                ],
                'js'=>[
                    'codemirror/codemirror.js',
                    'codemirror/mode/css/css.js',
                    'codemirror/mode/xml/xml.js',
                    'codemirror/mode/htmlmixed/htmlmixed.js'
                ]
            ],*/
        ]
    ],
];
