<?php
/* @var $this yii\web\View */

/* @var $order core\entities\Shop\Order\Order */

/* @var $model core\forms\manage\Shop\Order\OrderEditForm */

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('shop/order', 'Update Order: ') . $order->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop/order', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $order->id, 'url' => ['view', 'id' => $order->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<?php

$form = ActiveForm::begin() ?>
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">
                        <?= Yii::t('shop/customer', 'Customer') ?>
                    </h3>

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
            <?= $form->field($model->customer, 'phone')->textInput() ?>
            <?= $form->field($model->customer, 'name')->textInput() ?>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <!--Footer-->
        </div>
        <!-- /.card-footer-->
    </div>
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">
                        <?=Yii::t('shop/delivery','Delivery')?>
                    </h3>

                    <div class='card-tools'>
                        <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
                        </button>
                        <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <?= $form->field($model->delivery, 'method')->dropDownList(
                        $model->delivery->deliveryMethodsList(),
                        ['prompt' => '--- Select ---']
                    ) ?>
                    <?= $form->field($model->delivery, 'index')->textInput() ?>
                    <?= $form->field($model->delivery, 'address')->textarea(['rows' => 3]) ?>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <!--Footer-->
                </div>
                <!-- /.card-footer-->
            </div>
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">
                        <?=Yii::t('shop/order','Note')?>
                    </h3>

                    <div class='card-tools'>
                        <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
                        </button>
                        <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <?= $form->field($model, 'note')->textarea(['rows' => 3]) ?>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-sm btn-shadow btn-gradient btn-success']) ?>
                    </div>
                    <!--Footer-->
                </div>
                <!-- /.card-footer-->
            </div>
        </div>
    </div>
</div>
<?php
    ActiveForm::end(); ?>
