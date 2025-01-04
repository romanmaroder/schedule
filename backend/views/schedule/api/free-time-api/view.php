<?php


/* @var $this \yii\web\View */

/* @var $model \core\entities\Schedule\Event\FreeTime */

use hail812\adminlte3\assets\PluginAsset;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

YiiAsset::register($this);
PluginAsset::register($this)->add(['sweetalert2']);

?>
<div class="free-time-view container-fluid">

    <?= DetailView::widget(
        [
            'model' => $model,
            'attributes' => [
                [
                    'attribute' => 'master_id',
                    'format' => 'raw',
                    'value' => fn($model) => Html::a(
                        Html::encode($model->master->username),
                        ['/employee/view', 'id' => $model->employee->id]
                    ) ?? $model->employee->getFullName(),

                ],
                [
                    'attribute' => 'additional_id',
                    'format' => 'raw',
                    'value' => fn ($model) =>
                         Html::a(
                            Html::encode($model->additional->name),
                            ['/schedule/additional-category/view', 'id' => $model->additional->category_id]
                        ),
                ],
                [
                    'attribute' => 'start',
                    'format' => ['date', 'php:d-m-Y / H:i '],
                ],
                [
                    'attribute' => 'end',
                    //'label'     => 'Время',
                    'format' => ['date', 'php:d-m-Y / H:i'],
                ],
                [
                    'attribute' => 'notice',
                    'visible' => $model->notice ?: false,
                    'format' => 'ntext',
                ],
            ],
        ]
    ) ?>
    <p>
        <?= Html::a(
            Yii::t('app', 'Update'),
            ['update', 'id' => $model->id],
            [
                'id' => 'edit-link',
                'onClick' => "$('#modal').find('.modal-body').load($(this).attr('href')); return false;",
                'class' => 'btn btn-primary btn-sm btn-shadow bg-gradient'
            ]
        ) ?>

        <?php

        /*$options = [
            'class' => 'btn btn-info btn-sm d-none',
            'href'  => 'sms:' . $model->client->phone . Yii::$app->sms->checkOperatingSystem(
                ) . Yii::$app->sms->messageText(
                    $model->event_time_start
                ),
            'title' => 'Отправить смс',
        ];

        if ($model->client->phone) {
            Html::removeCssClass($options, 'd-none');
            Html::addCssClass($options, 'd-inline-block');
        }
        echo Html::tag('a', '<i class="far fa-envelope"></i>', $options);*/

        ?>
        <?php

        /*$options = [
            'class' => 'btn btn-info btn-sm d-none',
            'href'  => 'sms:' . $model->client->phone . Yii::$app->sms->checkOperatingSystem(
                ) . Yii::$app->sms->messageAddress(),
            'title' => 'Отправить адрес',
        ];

        if ($model->client->phone) {
            Html::removeCssClass($options, 'd-none');
            Html::addCssClass($options, 'd-inline-block');
        }
        echo Html::tag('a', '<i class="fas fa-map-marker-alt"></i>', $options);*/

        ?>
        <?= Html::a(
            Yii::t('app', 'Copy'),
            ['copy', 'id' => $model->id],
            [
                'id' => 'copy-link',
                'onClick' => "$('#modal').find('.modal-body').load($(this).attr('href')); return false;",
                'class' => 'btn btn-secondary btn-sm btn-shadow bg-gradient'
            ]
        ) ?>
        <?= Html::a(
            Yii::t('app', 'Delete'),
            ['delete', 'id' => $model->id],
            [
                'id' => 'delete',
                'class' => 'btn btn-danger btn-sm btn-shadow bg-gradient ml-5',
                'data' => [
                    'confirm' => Yii::t('app', 'Delete file?'),
                    'method' => 'post',
                ],
            ]
        ) ?>


    </p>
</div>