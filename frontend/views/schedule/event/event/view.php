<?php

use hail812\adminlte3\assets\PluginAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \schedule\entities\Schedule\Event\Event */

$this->title = $model->client->username;
$this->params['breadcrumbs'][] = ['label' => 'Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-view container-fluid">

    <?= DetailView::widget(
        [
            'model' => $model,
            'attributes' => [
                [
                    'attribute' => 'master_id',
                    'value' => function ($model) {
                        return Html::a(
                            Html::encode($model->master->username),
                            ['/users/user/view','id'=>$model->master->id]
                        );
                    },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'client_id',
                    'value' => function ($model) {
                        return Html::a(
                            Html::encode($model->client->username),
                            ['/users/user/view','id'=>$model->client->id]

                        );
                    },
                    'format' => 'raw',
                ],

                [
                    'label' => 'Service',
                    'value' => implode(', ', ArrayHelper::getColumn($model->services, 'name')),
                    'contentOptions' => ['class'=>'text-break'],
                ],
                [
                    'attribute' => 'notice',
                    'format' => 'ntext',
                ],
                [
                    'attribute' => 'start',
                    'format' => ['date', 'php:d-m-Y / H:i '],
                ],
                [
                    'attribute' => 'end',
                    'format' => ['date', 'php:d-m-Y / H:i'],
                ],
            ],
        ]
    ) ?>
</div>