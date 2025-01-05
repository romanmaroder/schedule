<?php


/* @var $this \yii\web\View */

/* @var $model \core\entities\Schedule\Event\FreeTime */


use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->master->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('schedule/event','Events'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="free-time-view container-fluid">
    <?= DetailView::widget(
        [
            'model' => $model,
            'attributes' => [
                [
                    'attribute' => 'master_id',
                    'format' => 'raw',
                    'value' => fn ($model) =>
                         Html::a(
                            Html::encode($model->master->username),
                            ['/employee/view', 'id' => $model->employee->id ?? $model->master_id]

                        )
                ],
                [
                    'attribute' => 'additional_id',
                    'format' => 'raw',
                    'value' => fn ($model) => Html::a(
                            Html::encode($model->additional->name),
                            ['/schedule/additional-category/view', 'id' => $model->additional->category_id]
                        )
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
                    'attribute' => 'notice',
                    'value' => $model->notice,
                    'visible' => $model->notice ?: false,
                    'format' => 'raw',

                ]
            ],
        ]
    ) ?>

</div>