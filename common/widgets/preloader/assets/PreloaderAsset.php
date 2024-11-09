<?php


namespace common\widgets\preloader\assets;


use yii\web\AssetBundle;

class PreloaderAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/preloader/web';

    public $css = [
        'css/preloader.css'
    ];
    public $js = [
        'js/preloader.js'
    ];
    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];
}