<?php

use core\helpers\ScheduleHelper;
use core\helpers\UserHelper;
use hail812\adminlte3\assets\PluginAsset;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var core\entities\user\User $model */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('user','Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

YiiAsset::register($this);
PluginAsset::register($this)->add(['sweetalert2']);
?>

<div class="container-fluid">
    <div class="row mb-2">
        <div class="col">
            <div class="card card-secondary">
                <div class="card-header">
                    <?= Html::a(Yii::t('app','Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-shadow btn-sm btn-gradient']) ?>
            <?= Html::a(Yii::t('app','Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger btn-shadow btn-sm btn-gradient',
                'id' => 'delete',
                'data' => [
                    'confirm' => Yii::t('app', 'Delete file?'),
                    'method' => 'post',
                ],
            ]) ?>

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
                'id',
                'username',
                [
                    'attribute' => 'email',
                    'visible' => $model->email ?: false,
                    'format' => 'email',
                ],
                [
                    'attribute' => 'phone',
                    'value' => function ($model) {
                        return Html::a(
                            Html::encode($model->phone),
                            'tel:' . $model->phone,
                            ['view', 'id' => $model->id]
                        );
                    },
                    'visible' => $model->phone ?: false,
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'status',
                    'value' => UserHelper::statusLabel($model->status),
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'schedule.hours',
                    'value' => ScheduleHelper::getWorkingHours($model->schedule->hoursWork),
                    'visible' => $model->schedule->hoursWork ?: false,
                ],
                [
                    'attribute' => 'schedule.days',
                    'value' => ScheduleHelper::getWeekends($model->schedule->weekends),
                    'visible' => $model->schedule->weekends ?: false,
                ],
                [
                    'attribute' => 'schedule.week',
                    'value' => function ($model) {
                        return $model->schedule->week;
                    },
                    'visible' => $model->schedule->week ?: false,
                ],
                [
                    'attribute' => 'notice',
                    'value' => function ($model) {
                        return $model->notice;
                    },
                    'visible' => $model->notice ?: false,
                    'format' => 'ntext',
                ],
                //'notice:ntext',
                'created_at:datetime',
                'updated_at:datetime',
            ],
        ]) ?>
    </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <!-- Footer-->
                </div>
                <!-- /.card-footer-->
            </div>
        </div>
    </div>
</div>
