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
        'css/shop/style.css',
    ];
    public $js = [
        'js/shop/main.js',
        'js/shop/lib/easing/easing.js',
        'js/shop/lib/owlcarousel/owl.carousel.js',
        'js/shop/mail/contact.js',
        'js/shop/mail/jqBootstrapValidation.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
    ];
}
