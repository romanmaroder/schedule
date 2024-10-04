<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $product \core\entities\Shop\Product\Product */
/* @var $model \core\forms\manage\Shop\Product\QuantityForm */

$this->title = Yii::t('shop/product','price:') . $product->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop/product','Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $product->name, 'url' => ['view', 'id' => $product->id]];
$this->params['breadcrumbs'][] = Yii::t('shop/product','Price');
?>
<div class="product-price">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-default">
        <div class="box-body">
            <?= $form->field($model, 'quantity')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-sm btn-gradient btn-shadow btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>