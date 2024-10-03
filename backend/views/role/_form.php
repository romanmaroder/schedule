<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\User\Role\RoleForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="role-form">

    <?php
    $form = ActiveForm::begin(); ?>
    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title"><?=Yii::t('app','Common')?></h3>
            <div class='card-tools'>
                <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
                </button>
                <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group">
                <?= $form->field($model, 'name')->textInput(
                    ['maxlength' => true, 'placeholder' => $model->getAttributeLabel('name')]
                )->label($model->getAttributeLabel('name')) ?>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-success btn-shadow btn-sm btn-gradient']) ?>
            <!--Footer-->
        </div>
        <!-- /.card-footer-->
    </div>

    <?php
    ActiveForm::end(); ?>
</div>
