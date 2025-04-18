<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $service \core\entities\Schedule\Service\Service */
/* @var $model core\forms\manage\Schedule\Service\PriceForm */

$this->title                   =Yii::t('schedule/service/price','Price for Service: ') . $service->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('schedule/service','Service'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $service->name, 'url' => ['view', 'id' => $service->id]];
$this->params['breadcrumbs'][] = Yii::t('app','Update');
?>
    <?php
    $form = ActiveForm::begin(); ?>
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col">
                <div class="card card-outline card-secondary">
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
            <?= $form->field($model, 'new')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'old')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="card-footer bg-secondary">
            <div class='form-group'>
                <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-success btn-shadow btn-sm btn-gradient']) ?>
            </div>
        </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    ActiveForm::end(); ?>
