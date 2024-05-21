<?php


namespace frontend\assets;


use yii\web\AssetBundle;

class BlogAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css
        = [
            'css/blog.css',
        ];

}