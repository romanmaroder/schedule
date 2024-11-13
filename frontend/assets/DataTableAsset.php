<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class DataTableAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/dataTable/dataTables.dateTime.css',
    ];
    public $js = [
        'js/dataTable/dataTables.dateTime.js',
        'js/dataTable/jszip.min.js',
        'js/dataTable/pdfmake.min.js',
        'js/dataTable/vfs_fonts.js',
        'js/dataTable/dark_mode.js',
    ];

}
