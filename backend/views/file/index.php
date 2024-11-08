<?php


/* @var $this \yii\web\View */

use mihaildev\elfinder\ElFinder;

$this->title = Yii::t('content/file','Files');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col">

            <?= ElFinder::widget(
        [
            'frameOptions' => ['style' => 'width: 100%; height: 640px; border: 0;']
        ]
    ); ?>

        </div>
    </div>
</div>