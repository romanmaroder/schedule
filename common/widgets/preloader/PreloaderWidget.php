<?php


namespace common\widgets\preloader;


use common\widgets\preloader\assets\PreloaderAsset;
use yii\base\Widget;

class PreloaderWidget extends Widget
{
    public function init(): void
    {
    }

    public function run(): string
    {
        PreloaderAsset::register($this->view);
        return $this->render('preloader');
    }
}