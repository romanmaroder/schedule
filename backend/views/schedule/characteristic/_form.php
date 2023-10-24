<?php



/* @var $this yii\web\View */
/* @var $model schedule\forms\manage\Schedule\CharacteristicForm */
/* @var $form yii\widgets\ActiveForm */

use yii\bootstrap4\ActiveForm;

?>

<div class="characteristic-form">

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
            <?= $form->field($model, 'type')->dropDownList($model->typesList()) ?>
            <?= $form->field($model, 'sort')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'required')->checkbox() ?>
            <?= $form->field($model, 'default')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'textVariants')->textarea(['rows' => 6]) ?>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <!--Footer-->
        </div>
        <!-- /.card-footer-->
    </div>

    <?php
    ActiveForm::end(); ?>
</div>
