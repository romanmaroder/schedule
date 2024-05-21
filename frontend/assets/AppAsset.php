<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        //'css/dataTables.dataTables.css',
        //'css/searchBuilder.dataTables.css',
        //'css/buttons.dataTables.css',
        'css/dataTable/dataTables.dateTime.css',
    ];
    public $js = [
        //'js/searchBuilder.dataTables.js',
        //'js/buttons.dataTables.js',
        'js/dataTable/dataTables.dateTime.js',
        //'js/dataTable/buttons.colVis.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
