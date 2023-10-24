<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model schedule\forms\manage\Schedule\BrandForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="brand-form">


    <?php
    $form = ActiveForm::begin(); ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title ">
                Common
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <!--Footer-->
        </div>
        <!-- /.card-footer-->
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                SEO
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <?= $form->field($model->meta, 'title')->textInput() ?>
            <?= $form->field($model->meta, 'description')->textarea(['rows' => 2]) ?>
            <?= $form->field($model->meta, 'keywords')->textInput() ?>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            <!--Footer-->
        </div>
        <!-- /.card-footer-->
    </div>
    <?php
    ActiveForm::end(); ?>
</div>
