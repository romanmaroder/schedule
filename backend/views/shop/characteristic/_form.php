<?php


use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\Shop\CharacteristicForm */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="characteristic-form">

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
            <div class="form-group">
                <?= $form->field($model, 'type')->dropDownList(
                    $model->typesList(),
                    [
                        'class' => 'custom-select form-control-border',
                        'placeholder' => $model->getAttributeLabel('type')
                    ]
                )->label($model->getAttributeLabel('type')) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'sort')->textInput(
                    ['placeholder' => $model->getAttributeLabel('sort')]
                )->label($model->getAttributeLabel('sort')) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'required')->checkbox(
                    ['class' => 'custom-control-input custom-control-input-success custom-control-input-outline']
                )->label($model->getAttributeLabel('required')) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'default')->textInput(
                    ['maxlength' => true, 'placeholder' => $model->getAttributeLabel('default')]
                )->label($model->getAttributeLabel('default')) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'textVariants')->textarea(
                    ['rows' => 6, 'placeholder' => $model->getAttributeLabel('textVariants')]
                )->label($model->getAttributeLabel('textVariants')) ?>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-success btn-sm btn-shadow btn-gradient']) ?>
            <!--Footer-->
        </div>
        <!-- /.card-footer-->
    </div>


    <?php
    ActiveForm::end(); ?>
</div>
