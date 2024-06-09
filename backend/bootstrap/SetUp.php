<?php


namespace backend\bootstrap;


use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use yii\base\Application;
use yii\base\BootstrapInterface;

class SetUp implements BootstrapInterface
{

    /**
     * @inheritDoc
     */
    public function bootstrap($app)
    {
        $container = \Yii::$container;

        $container->set(CKEditor::class, [
            'editorOptions' => ElFinder::ckeditorOptions('elfinder'),
        ]);
    }
}