<?php

/* @var $this yii\web\View */

/* @var $dataProvider yii\data\DataProviderInterface */

?>

<?= \yii\widgets\ListView::widget(
    [
        'dataProvider' => $dataProvider,
        'layout' => "{items}\n{pager}",
        'itemView' => '_post',
        'itemOptions' => [
            'tag' => false,
            'class'=>'text-center'
        ],
        'emptyTextOptions'=>[
            'class'=>'text-center'
        ],
        'emptyText' => 'There are no articles',
    ]
) ?>



