<?php

use hail812\adminlte3\assets\PluginAsset;
use schedule\helpers\ScheduleHelper;
use schedule\helpers\UserHelper;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var schedule\entities\user\User $model */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

YiiAsset::register($this);
PluginAsset::register($this)->add(['sweetalert2']);
?>


<div class="card card-secondary">
    <div class="card-header">
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-shadow']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger btn-shadow',
                'id' => 'delete',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
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
                    'attribute' => 'Hours',
                    'value' => ScheduleHelper::getWorkingHours($model->schedule->hoursWork),
                    'visible' => $model->schedule->hoursWork ?: false,
                ],
                [
                    'attribute' => 'Days',
                    'value' => ScheduleHelper::getWeekends($model->schedule->weekends),
                    'visible' => $model->schedule->weekends ?: false,
                ],
                [
                    'attribute' => 'Week',
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

