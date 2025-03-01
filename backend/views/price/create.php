<?php



/* @var $this \yii\web\View */
/* @var $model \core\forms\manage\User\Price\CreateForm */

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('price','Create price');
$this->params['breadcrumbs'][] = ['label' => Yii::t('price','Prices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="multiprice-create container-fluid">

    <?php

    $form = ActiveForm::begin(
        [
            'id' => 'event-form',
            'enableAjaxValidation' => false,
        ]
    ); ?>
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col">
                <div class="card card-secondary">
                    <div class='card-header'>
                        <h3 class='card-title'><?=Yii::t('app','Common')?></h3>
                        <div class='card-tools'>
                            <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
                            </button>
                            <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group"><?= $form->field($model, 'name')->textInput() ?></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group"><?= $form->field($model, 'rate')->textInput() ?></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <?= $form->field($model->services, 'lists')->widget(
                                        Select2::class,
                                        [
                                            'name' => 'lists',
                                            'language' => 'ru',
                                            'data' => $model->services->servicesList(),
                                            'theme' => Select2::THEME_BOOTSTRAP,
                                            'options' => [
                                                'id' => 'lists',
                                                'placeholder' => 'Select',
                                                'multiple' => true,
                                                'autocomplete' => 'off',
                                            ],
                                            'pluginOptions' => [
                                                'tags' => true,
                                                'allowClear' => true,
                                            ],
                                        ]
                                    ) ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-success btn-sm btn-shadow bg-gradient text-shadow']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    ActiveForm::end(); ?>

</div>