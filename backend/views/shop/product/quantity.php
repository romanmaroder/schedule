<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $product \core\entities\Shop\Product\Product */
/* @var $model \core\forms\manage\Shop\Product\QuantityForm */

$this->title = Yii::t('shop/product','price:') . $product->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop/product','Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $product->name, 'url' => ['view', 'id' => $product->id]];
$this->params['breadcrumbs'][] = Yii::t('shop/product','Price');
?>


    <?php $form = ActiveForm::begin(); ?>
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col">
            <div class="box box-default">
                <div class="box-body">
                    <?= $form->field($model, 'quantity')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-sm btn-gradient btn-shadow btn-success']) ?>
    </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

