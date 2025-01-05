<?php


/* @var $this \yii\web\View */

/* @var $model \core\entities\Schedule\Event\Education */

use yii\helpers\ArrayHelper;
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
                    'value' => fn ($model) =>
                         Html::a(
                            Html::encode($model->teacher->username),
                            ['/users/user/view', 'id' => $model->teacher->id]

                        ),
                ],
                [
                    'attribute' => 'student_ids',
                    'format' => 'raw',
                    'value' => fn($model) => implode(
                        '/ ',
                        ArrayHelper::getColumn($model->students, fn($student) => Html::a(
                                Html::encode($student->username),
                                ['/user/view', 'id' => $student->id]
                            ) . PHP_EOL)
                    ),
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