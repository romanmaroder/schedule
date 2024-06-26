<?php

/* @var $this yii\web\View */

/* @var $employee \core\entities\User\Employee\Employee */

/* @var $model \core\forms\manage\User\Employee\EmployeeEditForm */

use kartik\date\DatePicker;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

$this->title = 'Profile';
$this->params['breadcrumbs'][] = $this->title;
$this->params['employee'] = $employee;

?>

<div class="active tab-pane" id="profile">
    <?php
    $form = ActiveForm::begin(['layout' => 'horizontal']); ?>

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
        <?= $form->field($model, 'email')->textInput(
            ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('email')]
        )->label($model->getAttributeLabel('email')) ?>
    </div>
    <div class="form-group">
        <?= $form->field($model, 'password')->passwordInput(
            ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('password')]
        )->label($model->getAttributeLabel('password'))->hint('Re-enter your password') ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'phone')->widget(
            MaskedInput::class,
            [
                'mask' => '+9[9][9] (999) 999-99-99',
            ]
        )->textInput(['placeholder' => $model->getAttributeLabel('phone')])->label(
            $model->getAttributeLabel('phone')
        ) ?>
    </div>
    <div class="form-group">
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
    <div class="form-group">
        <?= $form->field($model->address, 'town')->textInput(
            ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('town')]
        )->label($model->getAttributeLabel('town')) ?>
    </div>
    <div class="form-group">
        <?= $form->field($model->address, 'borough')->textInput(
            ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('borough')]
        )->label($model->getAttributeLabel('borough')) ?>
    </div>
    <div class="form-group">
        <?= $form->field($model->address, 'street')->textInput(
            ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('street')]
        )->label($model->getAttributeLabel('street')) ?>
    </div>
    <div class="form-group">
        <?= $form->field($model->address, 'home')->textInput(
            ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('home')]
        )->label($model->getAttributeLabel('home')) ?>
    </div>
    <div class="form-group">
        <?= $form->field($model->address, 'apartment')->textInput(
            ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('apartment')]
        )->label($model->getAttributeLabel('apartment')) ?>
    </div>

    <div class="form-group">
        <div class="offset-sm-2 col-sm-10">
            <?= Html::submitButton('Save', ['class' => 'btn btn-danger btn-sm btn-shadow']) ?>
        </div>
    </div>
    <?php
    ActiveForm::end(); ?>

</div>

