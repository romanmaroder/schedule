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
                            ['/users/user/view', 'id' => $model->teacher->id]

                        );
                    },
                ],
                [
                    'attribute' => 'student_ids',
                    'format' => 'raw',
                    'value' => function ($model) {
                        $st = '';
                        foreach ($model->students as $student) {
                            $st .= Html::a(
                                    Html::encode($student->username),
                                    ['/users/user/view', 'id' => $student->id]
                                ) . ',' . PHP_EOL;
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