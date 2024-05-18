<?php

/* @var $this yii\web\View */

/* @var $model schedule\forms\manage\PageForm */

/* @var $form yii\widgets\ActiveForm */

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

?>



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
            <?= $form->field($model, 'parentId')->dropDownList($model->parentsList()) ?>
        </div>
        <div class="form-group">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="form-group">
            <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="form-group">
            <?= $form->field($model, 'content')->textarea(['rows' => 15]) ?>
        </div>

    </div>
</div>

<div class="card card-secondary">
    <div class="card-header">
        <h3 class="card-title">SEO</h3>
        <div class='card-tools'>
            <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
            </button>
            <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="form-group">
            <?= $form->field($model->meta, 'title')->textInput() ?>
        </div>
        <div class="form-group">
            <?= $form->field($model->meta, 'description')->textarea(['rows' => 2]) ?>
        </div>
        <div class="form-group">
            <?= $form->field($model->meta, 'keywords')->textInput() ?>
        </div>
    </div>
</div>

<div class="card-footer">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-sm btn-gradient btn-shadow']) ?>
    <!--Footer-->
</div>
<!-- /.card-footer-->

<?php
ActiveForm::end(); ?>

