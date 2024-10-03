<?php

use kartik\widgets\FileInput;
use mihaildev\ckeditor\CKEditor;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model core\forms\manage\Blog\Post\PostForm */
?>

<div class="post-form">

    <?php
    $form = ActiveForm::begin(
        [
            'enableClientValidation' => true,
            'options' => ['enctype' => 'multipart/form-data']
        ]
    ); ?>

    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title"><?= Yii::t('app','Common')?></h3>
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
                <?= $form->field($model, 'content')->widget(CKEditor::class) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'file')->label(false)->widget(FileInput::class, [
                    'options' => [
                        'accept' => 'image/*',
                        //'multiple'=>true
                    ]
                ]) ?>
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
        <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-success btn-sm btn-shadow bg-gradient text-shadow']) ?>
    </div>

    <?php
    ActiveForm::end(); ?>

</div>