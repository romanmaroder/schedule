<?php



/* @var $this \yii\web\View */
/* @var $model \core\entities\Schedule\Event\Education */

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
    <?php
    if (Yii::$app->id == 'app-backend'): ?>
        <p>
            <?= Html::a(
                'Update',
                ['update', 'id' => $model->id],
                [
                    'id' => 'edit-link',
                    'onClick' => "$('#modal').find('.modal-body').load($(this).attr('href')); return false;",
                    'class' => 'btn btn-primary btn-sm btn-shadow bg-gradient text-shadow'
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
                'Delete',
                ['delete', 'id' => $model->id],
                [
                    'id' => 'delete',
                    'class' => 'btn btn-danger btn-sm btn-shadow bg-gradient text-shadow',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]
            ) ?>
        </p>
    <?php
    endif; ?>
</div>