<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;


/* @var $this \yii\web\View */
/* @var $model \core\forms\manage\Expenses\CategoryForm|\yii\db\ActiveRecord */
?>

<div class="category-form">

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
                <?= $form->field($model, 'parentId')->dropDownList(
                    $model->parentCategoriesList(),
                    [
                        'class' => 'custom-select form-control-border',
                        'placeholder' => $model->getAttributeLabel('parentId')
                    ]
                )->label($model->getAttributeLabel('parentId')) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'name')->textInput(
                    ['maxlength' => true, 'placeholder' => $model->getAttributeLabel('name')]
                )->label($model->getAttributeLabel('name')) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'slug')->textInput(
                    [
                        'maxlength' => true,
                        'placeholder' => $model->getAttributeLabel('slug')
                    ]
                )->label($model->getAttributeLabel('slug')) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'title')->textInput(
                    [
                        'maxlength' => true,
                        'placeholder' => $model->getAttributeLabel('title')
                    ]
                )->label($model->getAttributeLabel('title')) ?>
            </div>
        </div>
        <div class="card-header">
            <h3 class="card-title">
                SEO
            </h3>
        </div>
        <div class="card-body">
            <div class="form-group">
                <?= $form->field($model->meta, 'title')->textInput(
                    ['maxlength' => true, 'placeholder' => $model->meta->getAttributeLabel('title')]
                )->label($model->meta->getAttributeLabel('title')) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model->meta, 'description')->textarea(
                    ['rows' => 2, 'placeholder' => $model->meta->getAttributeLabel('description')]
                )->label($model->meta->getAttributeLabel('description')) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model->meta, 'keywords')->textInput(
                    ['maxlength' => true, 'placeholder' => $model->meta->getAttributeLabel('keywords')]
                )->label($model->meta->getAttributeLabel('keywords')) ?>
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