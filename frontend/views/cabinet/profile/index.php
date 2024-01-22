<?php

/* @var $this yii\web\View */

/* @var $employee \schedule\entities\User\Employee\Employee */

/* @var $user \schedule\entities\User\User */

/* @var $model \schedule\forms\manage\User\Employee\EmployeeEditForm */

use kartik\color\ColorInput;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use schedule\helpers\PriceHelper;
use schedule\helpers\RateHelper;
use schedule\helpers\RoleHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

$this->title = 'Profile';
$this->params['breadcrumbs'][] = $this->title;
$this->params['user'] = $user;

?>

<div class="active tab-pane" id="profile">
    <?php
    /*    $form = ActiveForm::begin(['layout' => 'horizontal',]); */ ?><!--
        <div class="form-group row">
            <?
    /*= $form->field($model, 'username')->textInput(['maxLength' => true]) */ ?>
        </div>
        <div class="form-group row">
            <?
    /*= $form->field($model, 'email')->textInput(['maxLength' => true]) */ ?>
        </div>
        <div class="form-group row">
            <?
    /*= $form->field($model, 'phone')->widget(
                    MaskedInput::class,
                    [
                        'mask' => '+9[9][9] (999) 999-99-99',
                    ]
                )->textInput(['placeholder' => $model->getAttributeLabel('phone')])->label(
                    $model->getAttributeLabel('phone')
                ) */ ?>
        </div>
        <div class="form-group row">
            <?
    /*= $form->field($model, 'password')->passwordInput(
                    ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('password')]
                )->label($model->getAttributeLabel('password'))->hint('Re-enter your password') */ ?>
        </div>
        <div class="form-group row">
            <div class="offset-sm-2 col-sm-10">
                <?
    /*= Html::submitButton('Save', ['class' => 'btn btn-danger btn-shadow']) */ ?>
            </div>
        </div>
    --><?php
    /*    ActiveForm::end(); */ ?>
    <?php
    $form = ActiveForm::begin(['layout' => 'horizontal']); ?>

    <div class="form-group row">
        <?= $form->field($model, 'firstName')->textInput(
            ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('firstName')]
        )->label($model->getAttributeLabel('firstName')) ?>
    </div>
    <div class="form-group row">
        <?= $form->field($model, 'lastName')->textInput(
            ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('lastName')]
        )->label($model->getAttributeLabel('lastName')) ?>
    </div>
    <div class="form-group row">
        <?= $form->field($model->user, 'email')->textInput(
            ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('email')]
        )->label($model->getAttributeLabel('email')) ?>
    </div>
    <div class="form-group row">
        <?= $form->field($model->user, 'password')->passwordInput(
            ['maxLength' => true, 'placeholder' => $model->user->getAttributeLabel('password')]
        )->label($model->user->getAttributeLabel('password'))->hint('Re-enter your password') ?>
    </div>
    <!--<div class="form-group row">
        <?/*= $form->field($model, 'rateId')->widget(
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
        ) */?>
    </div>-->
    <!--<div class="form-group row">
        <?/*= $form->field($model, 'priceId')->widget(
            Select2::class,
            [
                'bsVersion' => '4.x',
                'name' => 'priceId',
                'data' => PriceHelper::priceList(),
                'theme' => Select2::THEME_KRAJEE_BS4, // this is the default if theme is not set
                'options' => ['placeholder' => 'Select a price ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],

            ]
        ) */?>
    </div>-->
    <div class="form-group row">
        <?= $form->field($model, 'phone')->widget(
            MaskedInput::class,
            [
                'mask' => '+9[9][9] (999) 999-99-99',
            ]
        )->textInput(['placeholder' => $model->getAttributeLabel('phone')])->label(
            $model->getAttributeLabel('phone')
        ) ?>
    </div>
    <div class="form-group row">
        <?= $form->field($model, 'birthday')->widget(
            DatePicker::class,
            [
                'options' => ['placeholder' => 'Enter birth date ...'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd.mm.yyyy'
                ]
            ]
        ) ?>
    </div>
    <!--<div class="form-group row">
        <?/*= $form->field($model, 'status')->textInput(
            ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('status')]
        )->label($model->getAttributeLabel('status')) */?>
    </div>-->
    <div class="form-group row">
        <?= $form->field($model->address, 'town')->textInput(
            ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('town')]
        )->label($model->getAttributeLabel('town')) ?>
    </div>
    <div class="form-group row">
        <?= $form->field($model->address, 'borough')->textInput(
            ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('borough')]
        )->label($model->getAttributeLabel('borough')) ?>
    </div>
    <div class="form-group row">
        <?= $form->field($model->address, 'street')->textInput(
            ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('street')]
        )->label($model->getAttributeLabel('street')) ?>
    </div>
    <div class="form-group row">
        <?= $form->field($model->address, 'home')->textInput(
            ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('home')]
        )->label($model->getAttributeLabel('home')) ?>
    </div>
    <div class="form-group row">
        <?= $form->field($model->address, 'apartment')->textInput(
            ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('apartment')]
        )->label($model->getAttributeLabel('apartment')) ?>
    </div>
    <!--<div class="form-group row">
        <?/*= $form->field($model, 'color')->widget(
            ColorInput::class,
            [
                'options' => ['placeholder' => 'Select color ...'],
            ]
        ) */?>
    </div>-->
    <!--<div class="form-group row">
        <?/*= $form->field($model, 'roleId')->widget(
            Select2::class,
            [
                'bsVersion' => '4.x',
                'name' => 'userId',
                'data' => RoleHelper::roleList(),
                'theme' => Select2::THEME_KRAJEE_BS4, // this is the default if theme is not set
                'options' => ['placeholder' => 'Select a role ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],

            ]
        ) */?>
    </div>-->
    <div class="form-group">
        <div class="offset-sm-2 col-sm-10">
            <?= Html::submitButton('Save', ['class' => 'btn btn-danger btn-shadow']) ?>
        </div>
    </div>


    <?php
    ActiveForm::end(); ?>

</div>

