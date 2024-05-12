<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model schedule\forms\manage\Blog\Post\PostForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php
    $form = ActiveForm::begin(
        [
            'options' => ['enctype' => 'multipart/form-data']
        ]
    ); ?>

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
                <?= $form->field($model, 'categoryId')->dropDownList($model->categoriesList(), ['prompt' => '']) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model->tags, 'existing')->checkboxList($model->tags->tagsList()) ?>
                <?= $form->field($model->tags, 'textNew')->textInput() ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'description')->textarea(['rows' => 5]) ?>
                <?= $form->field($model, 'content')->textarea(['rows' => 20]) ?>
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
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-sm btn-shadow bg-gradient text-shadow']) ?>
    </div>

    <?php
    ActiveForm::end(); ?>

</div>