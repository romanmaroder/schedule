<?php



/* @var $this \yii\web\View */
/* @var $model \schedule\entities\Schedule\Event\Education */

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Lesson', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="education-view container-fluid">

    <?= DetailView::widget(
        [
            'model' => $model,
            'attributes' => [
                [
                    'attribute' => 'teacher_id',
                    'format' => 'raw',
                    'value' => function ($model) {
                        //return '<span style="color: ' . $data->master->color . '">' . $data->master->username . '</p>';
                        return $model->teacher->username;
                    }
                ],
                [
                    'attribute' => 'student_id',
                    'format' => 'raw',
                    'value' => function ($model) {
                        //return '<span style="color: ' . $data->master->color . '">' . $data->master->username . '</p>';
                        return $model->student->username;
                    }
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
                        'method' => 'post',
                    ],
                ]
            ) ?>
        </p>
    <?php
    endif; ?>
</div>