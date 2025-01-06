<?php

use core\entities\User\Employee\Employee;
use core\helpers\EmployeeHelper;
use core\helpers\ScheduleHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var core\entities\User\Employee\Employee $model */

$this->title = $model->getFullName();
$this->params['breadcrumbs'][] = ['label' => Yii::t('user/employee','Employees'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <div class="row mb-2">
        <div class="col">
            <div class="card card-secondary">
                <div class="card-header">
                    <?= Html::a(Yii::t('app','Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-shadow btn-sm btn-gradient']) ?>
        <?= Html::a(
            Yii::t('app','Delete'),
            ['delete', 'id' => $model->id],
            [
                'class' => 'btn btn-danger btn-shadow btn-sm btn-gradient delete',
                'data' => [
                    'confirm' => Yii::t('app', 'Delete file?'),
                    'method' => 'post',
                    'id' => $model->id
                ],
            ]
        ) ?>

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
                    'id',
                    'first_name',
                    'last_name',
                    [
                        'attribute' => 'employee.phone',
                        'value' => fn (Employee $model)=> Html::a(
                                Html::encode(
                                    $model->phone
                                ),
                                'tel:' . $model->phone,
                                ['view', 'id' => $model->id]
                            ),
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'user.phone',
                        'value' => fn (Employee $model)=>
                                Html::a(
                                    Html::encode($model->user->phone),
                                    'tel:' . $model->user->phone,
                                    ['view', 'id' => $model->user->id]
                                ),
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'birthday',
                        'visible' => $model->issetBirthday($model->birthday),
                    ],
                    [
                        'attribute' => 'role_id',
                        'value' => fn ($model) => $model->role->name,
                    ],
                    [
                        'attribute' => 'role',
                        'value' => fn($model)=>EmployeeHelper::rolesLabel($model->user_id),
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'rate_id',
                        'value' => fn ($model) => $model->rate->name,
                    ],
                    [
                        'attribute' => 'price_id',
                        'value' => fn ($model) =>
                             $model->price->name,
                    ],
                    [
                        'attribute' => 'status',
                        'value' => fn ($model) =>
                             EmployeeHelper::statusLabel($model->status),
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'address.town',
                        'visible' => $model->issetAddress($model->address->town),
                    ],
                    [
                        'attribute' => 'address.borough',
                        'visible' => $model->issetAddress($model->address->borough),
                    ],
                    [
                        'attribute' => 'address.street',
                        'visible' => $model->issetAddress($model->address->street),
                    ],
                    [
                        'attribute' => 'address.home',
                        'visible' => $model->issetAddress($model->address->home),
                    ],
                    [
                        'attribute' => 'address.apartment',
                        'visible' => $model->issetAddress($model->address->apartment),
                    ],
                    [
                        'attribute' => 'color',
                        'value' => fn (Employee $model) =>
                             Html::tag(
                                'div',
                                '',
                                ['style' => 'width:20px;height:20px;background-color:' . $model->color]
                            ),
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'schedule.hours',
                        'value' => ScheduleHelper::getWorkingHours($model->schedule->hoursWork),
                    ],
                    [
                        'attribute' => 'schedule.weekends',
                        'value' => ScheduleHelper::getWeekends($model->schedule->weekends),
                    ],
                    //'notice:ntext'
                ],
            ]
        ) ?>
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
