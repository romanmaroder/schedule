<?php

use core\helpers\EmployeeHelper;
use core\helpers\RateHelper;
use core\helpers\RoleHelper;
use core\helpers\ScheduleHelper;
use kartik\color\ColorInput;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

/** @var $this \yii\web\View $this */
/** @var $model \core\forms\manage\User\Employee\EmployeeCreateForm */

$this->title = Yii::t('user/employee', 'Create Employee');
$this->params['breadcrumbs'][] = ['label' => Yii::t('user/employee', 'Employees'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$form = ActiveForm::begin(); ?>
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">
                        <?=Yii::t('app', 'Common')?>
                    </h3>
                    <div class='card-tools'>
                        <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
                        </button>
                        <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <?= $form->field($model, 'firstName')->textInput(
                            ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('firstName')]
                        )->label($model->getAttributeLabel('firstName')) ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model, 'lastName')->textInput(
                            ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('lastName')]
                        )->label($model->getAttributeLabel('lastName')) ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model->user, 'email')->textInput(
                            ['maxLength' => true, 'placeholder' => $model->user->getAttributeLabel('email')]
                        )->label($model->user->getAttributeLabel('email')) ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model->user, 'password')->passwordInput(
                            ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('password')]
                        )->label($model->user->getAttributeLabel('password')) ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model, 'rateId')->widget(
                            Select2::class,
                            [
                                'bsVersion' => '4.x',
                                'name' => 'rateId',
                                'data' => RateHelper::rateList(),
                                'theme' => Select2::THEME_KRAJEE_BS4, // this is the default if theme is not set
                                'options' => ['placeholder' => 'Select a rate ...'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],

                            ]
                        ) ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model, 'priceId')->widget(
                            Select2::class,
                            [
                                'bsVersion' => '4.x',
                                'name' => 'priceId',
                                'data' => \core\helpers\PricesHelper::priceList(),
                                'theme' => Select2::THEME_KRAJEE_BS4, // this is the default if theme is not set
                                'options' => ['placeholder' => 'Select a price ...'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],

                            ]
                        ) ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model, 'phone')->widget(MaskedInput::class, [
                            'mask' => '+9[9][9] (999) 999-99-99',
                        ])->textInput(['placeholder' => $model->getAttributeLabel('phone')])->label($model->getAttributeLabel('phone')) ?>
                    </div>

                    <div class="form-group">
                        <?= $form->field($model, 'birthday')->widget(DatePicker::class, [
                            'options' => ['placeholder' => 'Enter birth date ...'],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'dd.mm.yyyy'
                            ]
                        ]) ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model, 'status')->widget(
                            Select2::class,
                            [
                                'bsVersion' => '4.x',
                                'name' => 'status',
                                'data' => EmployeeHelper::statusList(),
                                'theme' => Select2::THEME_KRAJEE_BS4, // this is the default if theme is not set
                                'options' => ['placeholder' => 'Select a status ...'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],

                            ]
                        ) ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model->address, 'town')->textInput(
                            ['maxLength' => true, 'placeholder' => $model->address->getAttributeLabel('town')]
                        )->label($model->address->getAttributeLabel('town')) ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model->address, 'borough')->textInput(
                            ['maxLength' => true, 'placeholder' => $model->address->getAttributeLabel('borough')]
                        )->label($model->address->getAttributeLabel('borough')) ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model->address, 'street')->textInput(
                            ['maxLength' => true, 'placeholder' => $model->address->getAttributeLabel('street')]
                        )->label($model->address->getAttributeLabel('street')) ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model->address, 'home')->textInput(
                            ['maxLength' => true, 'placeholder' => $model->address->getAttributeLabel('home')]
                        )->label($model->address->getAttributeLabel('home')) ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model->address, 'apartment')->textInput(
                            ['maxLength' => true, 'placeholder' => $model->address->getAttributeLabel('apartment')]
                        )->label($model->address->getAttributeLabel('apartment')) ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model->schedule, 'hoursWork')->widget(
                            Select2::class,
                            [
                                'name' => 'hoursWork',
                                'language' => 'ru',
                                'data' => ScheduleHelper::hours(),
                                'theme' => Select2::THEME_BOOTSTRAP,
                                'options' => [
                                    'id' => 'hoursWork',
                                    'placeholder' => 'Select',
                                    'multiple' => true,
                                    'autocomplete' => 'off',
                                ],
                                'pluginOptions' => [
                                    'tags' => true,
                                    'allowClear' => true,
                                ],
                            ]
                        ) ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model->schedule, 'weekends')->widget(
                            Select2::class,
                            [
                                'name' => 'weekends',
                                'language' => 'ru',
                                'data' => ScheduleHelper::days(),
                                'theme' => Select2::THEME_BOOTSTRAP,
                                'options' => [
                                    'id' => 'weekends',
                                    'placeholder' => 'Select',
                                    'multiple' => true,
                                    'autocomplete' => 'off',
                                ],
                                'pluginOptions' => [
                                    'tags' => true,
                                    'allowClear' => true,
                                ],
                            ]
                        ) ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model, 'color')->widget(
                            ColorInput::class,
                            [
                                'options' => ['placeholder' => 'Select color ...'],
                            ]
                        ) ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model, 'roleId')->widget(
                            Select2::class,
                            [
                                //'bsVersion' => '4.x',
                                'name' => 'roleId',
                                'data' => RoleHelper::roleList(),
                                'theme' => Select2::THEME_KRAJEE_BS4, // this is the default if theme is not set
                                'options' => ['placeholder' => 'Select a role ...'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],

                            ]
                        ) ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model, 'role')->widget(
                            Select2::class,
                            [
                                //'bsVersion' => '4.x',
                                'name' => 'roleId',
                                'data' => $model->rolesList(),
                                'theme' => Select2::THEME_KRAJEE_BS4, // this is the default if theme is not set
                                'options' => ['placeholder' => 'Select a role ...'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],

                            ]
                        ) ?>
                    </div>
                </div>
</div>
<!-- /.card-body -->
<div class="card-footer">
    <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-success btn-shadow btn-sm btn-gradient']) ?>
</div>
            <!-- /.card-footer-->
        </div>
    </div>
</div>
<?php
ActiveForm::end(); ?>
