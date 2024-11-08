<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model core\forms\manage\Blog\TagForm */
/* @var $form yii\widgets\ActiveForm */
?>
    <?php
    $form = ActiveForm::begin(); ?>
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col">
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
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-sm btn-shadow bg-gradient text-shadow']) ?>
                        <!--Footer-->
                    </div>
                    <!-- /.card-footer-->
                </div>
            </div>
        </div>
    </div>
    <?php
    ActiveForm::end(); ?>
