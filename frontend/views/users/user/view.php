<?php

use core\helpers\ScheduleHelper;
use core\helpers\StatusHelper;
use core\helpers\UserHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var core\entities\user\User $model */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('user/user','Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>


<div class="card card-secondary">
    <div class="card-header">

        <div class='card-tools'>
            <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
            </button>
            <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'username',
                [
                    'attribute' => 'email',
                    'visible' => $model->email ?: false,
                    'format' => 'email',
                ],
                [
                    'attribute' => 'status',
                    'value' => StatusHelper::statusLabel($model->status),
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'phone',
                    'value' => fn ($model) =>
                         Html::a(
                            Html::encode($model->phone),
                            'tel:' . $model->phone,
                            ['view', 'id' => $model->id]
                        ),
                    'format' => 'raw',
                    'visible' => $model->phone ?: false,
                ],
                [
                    'attribute' => 'Hours',
                    'value' => ScheduleHelper::getWorkingHours($model->schedule->hoursWork),
                    'visible' => ScheduleHelper::getWorkingHours($model->schedule->hoursWork) ?: false,
                ],
                [
                    'attribute' => 'Days',
                    'value' => ScheduleHelper::getWeekends($model->schedule->weekends),
                    'visible' => ScheduleHelper::getWeekends($model->schedule->weekends) ?: false,
                ],
                [
                    'attribute' => 'Week',
                    'value' => fn($model)=> $model->schedule->week,
                    'visible' => $model->schedule->weekends ?: false,
                ],
                [
                    'attribute' => 'Notice',
                    'value' => fn($model)=> $model->notice,
                    'visible' => $model->notice ?: false,
                ]
                //'created_at:datetime',
                //'updated_at:datetime',
            ],
        ]) ?>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
       <!-- Footer-->
    </div>
    <!-- /.card-footer-->
</div>

