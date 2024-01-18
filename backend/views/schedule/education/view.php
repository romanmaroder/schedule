<?php



/* @var $this \yii\web\View */
/* @var $model \schedule\entities\Schedule\Event\Education */

use hail812\adminlte3\assets\PluginAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Lesson', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

YiiAsset::register($this);
PluginAsset::register($this)->add(['sweetalert2']);
?>

<div class="education-view container-fluid">

    <div class="card card-secondary">
        <div class='card-header'>
            <h3 class='card-title'><?=$model->title?></h3>
            <div class='card-tools'>
                <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
                </button>
                <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <?= DetailView::widget(
                [
                    'model' => $model,
                    'attributes' => [
                        [
                            'attribute' => 'teacher_id',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return Html::a(
                                    Html::encode($model->teacher->username),
                                    ['/user/view', 'id' => $model->teacher->id]
                                );
                            }
                        ],
                        [
                            'attribute' => 'student_ids',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $st = '';
                                foreach ($model->students as $student) {
                                    $st .= Html::a(
                                            Html::encode($student->username),
                                            ['/user/view', 'id' => $student->id]
                                        ) .'/'. PHP_EOL;
                                }
                                return $st;
                            },
                            'contentOptions' => ['class' => 'text-break'],
                        ],
                        [
                            'attribute' => 'title',
                            'format' => 'ntext',
                        ],
                        [
                            'attribute' => 'description',
                            'format' => 'ntext',
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

                    ],
                ]
            ) ?>
        </div>
        <div class="card-footer">
            <?php
            if (Yii::$app->id == 'app-backend'): ?>
                <p>
                    <?= Html::a(
                        'Update',
                        ['update', 'id' => $model->id],
                        [
                            'id' => 'edit-link',
                            'class' => 'btn btn-primary btn-sm btn-shadow'
                        ]
                    ) ?>
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