<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $service schedule\entities\Schedule\Service\Service */
/* @var $model schedule\forms\manage\Schedule\Service\PriceForm */

$this->title                   = 'Price for Service: ' . $service->name;
$this->params['breadcrumbs'][] = ['label' => 'Service', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $service->name, 'url' => ['view', 'id' => $service->id]];
$this->params['breadcrumbs'][] = 'Price';
?>
<div class="service-price">

    <?php
    $form = ActiveForm::begin(); ?>

    <div class="card card-outline card-secondary">
        <div class='card-header'>
            <h3 class='card-title'>Common</h3>
            <div class='card-tools'>
                <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
                </button>
                <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <?= $form->field($model, 'new')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'old')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'intern')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'employee')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="card-footer bg-secondary">
            <div class='form-group'>
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php
    ActiveForm::end(); ?>

</div>