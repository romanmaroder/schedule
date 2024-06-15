<?php

namespace shop\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap',
        'css/shop/style.css',
    ];
    public $js = [
        'js/shop/main.js',
        'js/shop/lib/easing/easing.js',
        'js/shop/mail/contact.js',
        'js/shop/mail/jqBootstrapValidation.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
    ];
}
