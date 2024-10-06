<?php

/* @var $this yii\web\View */

/* @var $employee \core\entities\User\Employee\Employee */

/* @var $user \core\entities\User\User */

/* @var $model \core\forms\user\ProfileEditForm */

use kartik\date\DatePicker;
use kartik\widgets\Select2;
use core\helpers\ScheduleHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

$this->title = Yii::t('cabinet/sidebar','Profile');
$this->params['breadcrumbs'][] = $this->title;
$this->params['user'] = $user;
$this->params['employee'] = $employee;

?>

<div class="active tab-pane" id="profile">
    <?php
    $form = ActiveForm::begin(['layout' => 'horizontal']); ?>

    <div class="form-group">
        <?= $form->field($model, 'firstName')->textInput(
            ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('firstName')]
        )->label($model->_employee->getAttributeLabel('first_name')) ?>
    </div>
    <div class="form-group">
        <?= $form->field($model, 'lastName')->textInput(
            ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('lastName')]
        )->label($model->_employee->getAttributeLabel('last_name')) ?>
    </div>
    <div class="form-group">
        <?= $form->field($model, 'email')->textInput(
            ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('email')]
        )->label($model->_employee->user->getAttributeLabel('email')) ?>
    </div>
    <div class="form-group">
        <?= $form->field($model, 'password')->passwordInput(
            ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('password')]
        )->label($model->_employee->user->getAttributeLabel('password'))
            /*->hint(Yii::t('cabinet/error','Re-enter your password'))*/ ?>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'phone')->widget(
            MaskedInput::class,
            [
                'mask' => '+9[9][9] (999) 999-99-99',
            ]
        )->textInput(['placeholder' => $model->getAttributeLabel('phone')])->label(
            $model->_employee->getAttributeLabel('phone')
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
        )->label( $model->_employee->getAttributeLabel('birthday')) ?>
    </div>
    <div class="form-group">
        <?= $form->field($model->address, 'town')->textInput(
            ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('town')]
        )->label($model->address->getAttributeLabel('town')) ?>
    </div>
    <div class="form-group">
        <?= $form->field($model->address, 'borough')->textInput(
            ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('borough')]
        )->label($model->address->getAttributeLabel('borough')) ?>
    </div>
    <div class="form-group">
        <?= $form->field($model->address, 'street')->textInput(
            ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('street')]
        )->label($model->address->getAttributeLabel('street')) ?>
    </div>
    <div class="form-group">
        <?= $form->field($model->address, 'home')->textInput(
            ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('home')]
        )->label($model->address->getAttributeLabel('home')) ?>
    </div>
    <div class="form-group">
        <?= $form->field($model->address, 'apartment')->textInput(
            ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('apartment')]
        )->label($model->address->getAttributeLabel('apartment')) ?>
    </div>

    <div class="form-group">
        <div class="offset-sm-2 col-sm-10">
            <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-danger btn-sm btn-shadow']) ?>
        </div>
    </div>
    <?php
    ActiveForm::end(); ?>

</div>

