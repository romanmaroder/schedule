<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\Shop\Product\ModificationForm */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
$form = ActiveForm::begin(); ?>
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title"><?= Yii::t('app', 'Common') ?></h3>
                    <div class='card-tools'>
                        <button type='button' class='btn btn-tool' data-card-widget='maximize'><i
                                    class='fas fa-expand'></i>
                        </button>
                        <button type='button' class='btn btn-tool' data-card-widget='collapse'><i
                                    class='fas fa-minus'></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model, 'quantity')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="form-group">
                        <?= Html::submitButton(
                            Yii::t('app', 'Save'),
                            ['class' => 'btn btn-success btn-sm btn-gradient btn-shadow']
                        ) ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php
ActiveForm::end(); ?>
