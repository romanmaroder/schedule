<?php

use core\helpers\EventPaymentStatusHelper;
use core\helpers\ToolsHelper;
use core\services\sms\simpleSms\SmsMessage;
use hail812\adminlte3\assets\PluginAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \core\entities\Schedule\Event\Event */
/* @var $cart \core\cart\schedule\Cart */
/* @var $sms \core\services\sms\SmsSender */

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
                        if ($model->employee !== null) {
                            return Html::a(
                                Html::encode($model->master->username),
                                ['/employee/view', 'id' => $model->employee->id]
                            );
                        }
                        return $model->getFullName();
                    }
                ],
                [
                    'attribute' => 'client_id',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return Html::a(
                            Html::encode($model->client->username),
                            ['/user/view', 'id' => $model->client->id]

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
                    'attribute' => 'service',
                    //'label' => 'Service',
                    'value' => implode(', ', ArrayHelper::getColumn($model->services, 'name')),
                    'contentOptions' => ['class' => 'text-break'],
                ],
                //'amount',
                [
                    'attribute' => 'cost',
                    'value' => $model->getDiscountedPrice($model, $cart),
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
                [
                    'attribute' => 'tools',
                    'value' => ToolsHelper::statusLabel($model->tools),
                    'format' => 'raw',
                ],

            ],
        ]
    ) ?>
    <p>
        <?php
        if ($model->isNotPayed()):?>


            <?= Html::a(
                '<i class="fas fa-pencil-alt"></i>',
                ['update', 'id' => $model->id],
                [
                    'id' => 'edit-link',
                    'title'=>Yii::t('app','Update'),
                    'onClick' => "$('#modal').find('.modal-body').load($(this).attr('href')); return false;",
                    'class' => 'btn btn-primary btn-sm btn-shadow bg-gradient'
                ]
            ) ?>
        <?php endif; ?>

        <?php
        if ($model->isToolsAreNotReady()):?>


            <?= Html::a(
                '<i class="fas fa-wrench"></i>',
                ['tools', 'id' => $model->id],
                [
                    'id' => 'tools-link',
                    'title'=>Yii::t('schedule/event','Tools'),
                    'onClick' => "$('#modal').find('.modal-body').load($(this).attr('href')); return false;",
                    'class' => 'btn btn-sm btn-secondary btn-shadow bg-gradient'
                ]
            ) ?>
        <?php endif; ?>


        <?php
        echo $sms->send($model, SmsMessage::REMAINDER_MESSAGE);
        echo $sms->send($model, SmsMessage::ADDRESS_MESSAGE);
        echo $sms->send($model, SmsMessage::QUESTION_MESSAGE);
        echo $sms->send($model, SmsMessage::PRICE_MESSAGE);

        ?>
        <?= Html::a(
            '<i class="far fa-copy"></i>',
            ['copy', 'id' => $model->id],
            [
                'id' => 'copy-link',
                'title'=>Yii::t('app', 'Copy'),
                'onClick' => "$('#modal').find('.modal-body').load($(this).attr('href')); return false;",
                'class' => 'btn btn-secondary btn-sm btn-shadow bg-gradient',
            ]
        ) ?>
        <?= Html::a(
            '<i class="fas fa-trash-alt"></i>',
            ['delete', 'id' => $model->id],
            [
                'id' => 'delete',
                'title'=> Yii::t('app', 'Delete'),
                'class' => 'btn btn-danger btn-sm btn-shadow bg-gradient ml-5',
                'data' => [
                    'confirm' => Yii::t('app', 'Delete file?'),
                    'method' => 'post',
                ],
            ]
        ) ?>


    </p>
</div>