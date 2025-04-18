<?php

use core\helpers\EventMethodsOfPayment;
use core\helpers\EventPaymentStatusHelper;
use core\helpers\ToolsHelper;
use hail812\adminlte3\assets\PluginAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \core\entities\Schedule\Event\Event */
/* @var $cart \core\cart\schedule\Cart */

$this->title = $model->client->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Events'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

YiiAsset::register($this);
PluginAsset::register($this)->add(['sweetalert2']);
?>
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col">
            <div class="card card-secondary">
                <div class='card-header'>
                    <h3 class='card-title'><?= $model->client->username ?></h3>
                    <div class='card-tools'>
                        <button type='button' class='btn btn-tool' data-card-widget='maximize'><i
                                    class='fas fa-expand'></i>
                        </button>
                        <button type='button' class='btn btn-tool' data-card-widget='collapse'><i
                                    class='fas fa-minus'></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <?= DetailView::widget(
                        [
                            'model' => $model,
                            'attributes' => [
                                [
                                    'attribute' => 'master_id',
                                    'format' => 'raw',
                                    'value' => fn($model) => Html::a(
                                        Html::encode($model->master->username),
                                        ['/employee/view', 'id' => $model->employee->id ?? $model->master_id]

                                    )
                                ],
                                [
                                    'attribute' => 'client_id',
                                    'format' => 'raw',
                                    'value' => fn($model) => Html::a(
                                        Html::encode($model->client->username),
                                        ['/user/view', 'id' => $model->client->id]

                                    )
                                ],
                                [
                                    'attribute' => 'notice',
                                    'format' => 'ntext',
                                    'visible' => $model->issetNotice($model->notice),
                                ],

                                [
                                    'attribute' => 'start',
                                    'format' => ['date', 'php:d-m-Y / H:i '],
                                ],
                                [
                                    'attribute' => 'end',
                                    'format' => ['date', 'php:d-m-Y / H:i'],
                                ],
                                [
                                    'attribute' => 'service',
                                    // 'label' => 'Service',
                                    'value' => implode(', ', ArrayHelper::getColumn($model->services, 'name')),
                                ],
                                'amount',
                                [
                                    'attribute' => 'cost',
                                    'value' => $model->getDiscountedPrice($model, $cart),
                                ],
                                [
                                    'attribute' => 'status',
                                    'value' => EventPaymentStatusHelper::statusLabel($model->status),
                                    'format' => 'raw',

                                ],
                                [
                                    'attribute' => 'payment',
                                    'value' => EventMethodsOfPayment::statusLabel($model->payment),
                                    'visible' => $model->payment ?: false,
                                    'format' => 'raw',

                                ],
                                [
                                    'attribute' => 'notice',
                                    'value' => $model->notice,
                                    'visible' => $model->notice ?: false,
                                    'format' => 'raw',

                                ],
                                [
                                    'attribute' => 'tools',
                                    'value' => ToolsHelper::statusLabel($model->tools),
                                    'format' => 'raw',
                                ],
                            ],
                        ]
                    ) ?>
                </div>
                <div class="card-footer">
                    <?php
                    if (Yii::$app->id == 'app-backend'): ?>
                        <p>
                            <?= Html::a(
                                Yii::t('app', 'Update'),
                                ['update', 'id' => $model->id],
                                [
                                    'id' => 'edit-link',
                                    'class' => 'btn btn-primary btn-sm btn-shadow bg-gradient'
                                ]
                            ) ?>

                            <?php
                            if ($model->isToolsAreNotReady()):?>
                                <?= Html::a(
                                    Yii::t('schedule/event', 'Tools'),
                                    ['tools', 'id' => $model->id],
                                    [
                                        'id' => 'tools-link',
                                        //'onClick' => "$('#modal').find('.modal-body').load($(this).attr('href')); return false;",
                                        'class' => 'btn btn-primary btn-sm btn-shadow bg-gradient'
                                    ]
                                ) ?>
                            <?php
                            endif; ?>
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
                                    'class' => 'btn btn-secondary btn-sm btn-shadow bg-gradient',
                                ]
                            ) ?>
                            <?= Html::a(
                                Yii::t('app', 'Delete'),
                                ['delete', 'id' => $model->id],
                                [
                                    'id' => 'delete',
                                    'class' => 'btn btn-danger btn-sm btn-shadow bg-gradient',
                                    'data' => [
                                        'confirm' => Yii::t('app', 'Delete file?'),
                                        'method' => 'POST',
                                    ],
                                ]
                            ) ?>
                        </p>
                    <?php
                    endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>