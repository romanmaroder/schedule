<?php

use schedule\entities\User\Employee\Employee;
use schedule\helpers\ScheduleHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var schedule\entities\User\Employee\Employee $model */

$this->title = $model->getFullName();
$this->params['breadcrumbs'][] = ['label' => 'Employee', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="card card-secondary">
    <div class="card-header">
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-shadow btn-sm btn-gradient']) ?>
        <?= Html::a(
            'Delete',
            ['delete', 'id' => $model->id],
            [
                'class' => 'btn btn-danger btn-shadow btn-sm btn-gradient delete',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
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
                        'value' => function (Employee $model) {
                            return Html::a(
                                Html::encode(
                                    $model->phone
                                ),
                                'tel:' . $model->phone,
                                ['view', 'id' => $model->id]
                            );
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'user.phone',
                        'value' => function (Employee $model) {
                            return
                                Html::a(
                                    Html::encode($model->user->phone),
                                    'tel:' . $model->user->phone,
                                    ['view', 'id' => $model->user->id]
                                );
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'birthday',
                        'visible' => $model->issetBirthday($model->birthday),
                    ],
                    [
                        'attribute' => 'role_id',
                        'value' => function ($model) {
                            return $model->role->name;
                        },
                    ],
                    [
                        'label' => 'Role',
                        'value' => implode(', ', ArrayHelper::getColumn(Yii::$app->authManager->getRolesByUser($model->user_id), 'description')),
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'rate_id',
                        'value' => function ($model) {
                            return $model->rate->name;
                        },
                    ],
                    [
                        'attribute' => 'price_id',
                        'value' => function ($model) {
                            return $model->price->name;
                        },
                    ],
                    [
                        'attribute' => 'status',
                        'value' => function ($model) {
                            return \schedule\helpers\EmployeeHelper::statusLabel($model->status);
                        },
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
                        'value' => function (Employee $model) {
                            return Html::tag(
                                'div',
                                '',
                                ['style' => 'width:20px;height:20px;background-color:' . $model->color]
                            );
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'Hours',
                        'value' => ScheduleHelper::getWorkingHours($model->schedule->hoursWork),
                    ],
                    [
                        'attribute' => 'Weekends',
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

