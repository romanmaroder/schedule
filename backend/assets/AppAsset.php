<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/dataTable/dataTables.dateTime.css',
    ];
    public $js = [
        'js/deletion_notice.js',
        'js/dataTable/dataTables.dateTime.js',
        'js/dataTable/jszip.min.js',
        'js/dataTable/pdfmake.min.js',
        'js/dataTable/vfs_fonts.js',
        'js/dataTable/dark_mode.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap5\BootstrapAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
