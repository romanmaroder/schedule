<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\Shop\DeliveryMethodForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="method-form">

    <?php
    $form = ActiveForm::begin(); ?>

    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title">Common</h3>
            <div class='card-tools'>
                <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
                </button>
                <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'cost')->textInput() ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'minWeight')->textInput() ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'maxWeight')->textInput() ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'sort')->textInput() ?>
            </div>
        </div>
    </div>

    <!-- /.card-body -->
    <div class="card-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-sm btn-shadow btn-gradient']) ?>
        <!--Footer-->
    </div>
    <!-- /.card-footer-->

    <?php
    ActiveForm::end(); ?>

</div>