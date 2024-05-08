<?php

use hail812\adminlte3\assets\PluginAsset;
use schedule\helpers\EventPaymentStatusHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \schedule\entities\Schedule\Event\Event */
/* @var $cart \schedule\cart\Cart */

YiiAsset::register($this);
PluginAsset::register($this)->add(['sweetalert2']);

?>
<div class="event-view container-fluid">

    <?= DetailView::widget(
        [
            'model' => $model,
            'attributes' => [
                [
                    'attribute' => 'master_id',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return Html::a(
                            Html::encode($model->master->username),
                            ['/employee/view','id'=>$model->employee->id]
                        );
                    }
                ],
                [
                    'attribute' => 'client_id',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return Html::a(
                            Html::encode($model->client->username),
                            ['/user/view','id'=>$model->client->id]

                        );
                    }
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
                    'label' => 'Service',
                    'value' => implode(', ', ArrayHelper::getColumn($model->services, 'name')),
                    'contentOptions' => ['class'=>'text-break'],
                ],
                //'amount',
                [
                    'attribute' => 'Cost',
                    'value' => $model->getDiscountedPrice($model,$cart),
                    'visible' => $model->isNotPayed(),
                ],
                [
                    'attribute' => 'status',
                    'value' => EventPaymentStatusHelper::statusLabel($model->status),
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'notice',
                    'visible' => $model->issetNotice($model->notice),
                    'format' => 'ntext',
                ],
            ],
        ]
    ) ?>
        <p>
            <?php
            if ($model->isNotPayed()):?>


            <?= Html::a(
                'Update',
                ['update', 'id' => $model->id],
                [
                    'id' => 'edit-link',
                    'onClick' => "$('#modal').find('.modal-body').load($(this).attr('href')); return false;",
                    'class' => 'btn btn-primary btn-sm btn-shadow'
                ]
            ) ?>
            <?php endif;?>

            <?php

            /*$options = [
                'class' => 'btn btn-info btn-sm d-none',
                'href'  => 'sms:' . $model->client->phone . Yii::$app->smsSender->checkOperatingSystem(
                    ) . Yii::$app->smsSender->messageText(
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
                'href'  => 'sms:' . $model->client->phone . Yii::$app->smsSender->checkOperatingSystem(
                    ) . Yii::$app->smsSender->messageAddress(),
                'title' => 'Отправить адрес',
            ];

            if ($model->client->phone) {
                Html::removeCssClass($options, 'd-none');
                Html::addCssClass($options, 'd-inline-block');
            }
            echo Html::tag('a', '<i class="fas fa-map-marker-alt"></i>', $options);*/
            ?>

            <?= Html::a(
                Yii::t('app', 'Delete'),
                ['delete', 'id' => $model->id],
                [
                    'id' => 'delete',
                    'class' => 'btn btn-danger btn-sm btn-shadow',
                    'data' => [
                        'confirm' => Yii::t('app', 'Delete file?'),
                        'method' => 'post',
                    ],
                ]
            ) ?>

            <?= Html::a(
                Yii::t('app', 'Copy'),
                ['copy', 'id' => $model->id],
                [
                    'id' => 'copy-link',
                    'onClick' => "$('#modal').find('.modal-body').load($(this).attr('href')); return false;",
                    'class' => 'btn btn-primary btn-sm btn-shadow'
                ]
            ) ?>
        </p>
</div>