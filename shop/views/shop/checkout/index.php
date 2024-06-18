<?php


/* @var $this \yii\web\View */

/* @var $cart \core\cart\shop\Cart */
/* @var $model \core\forms\Shop\Order\OrderForm */

/* @var $user \core\entities\User\User */

use core\helpers\PriceHelper;
use core\helpers\WeightHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\MaskedInput;

$this->title = 'Checkout';
$this->params['breadcrumbs'][] = ['label' => 'Catalog', 'url' => ['/shop/catalog/index']];
$this->params['breadcrumbs'][] = ['label' => 'Shopping Cart', 'url' => ['/shop/cart/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- Checkout Start -->
<div class="container-fluid pt-5">
    <?php
    $form = ActiveForm::begin() ?>
    <div class="row px-xl-5">
        <div class="col-lg-8">
            <div class="mb-4">
                <h4 class="font-weight-semi-bold mb-4">Billing Address</h4>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <?= $form->field($model->customer, 'first_name')->textInput(['placeholder' => 'John']) ?>
                        <?= $form->field($model->customer, 'last_name')->textInput(['placeholder' => 'Doe']) ?>
                        <?= $form->field($model->customer, 'phone')->widget(
                            MaskedInput::class,
                            [
                                'mask' => '+9[9][9] (999) 999-99-99',
                            ]
                        )->textInput(['placeholder' => 'Mobile No'])->label('Mobile No') ?>
                    </div>
                    <div class="col-md-6 form-group">
                            <?= $form->field($model->delivery, 'method')->dropDownList(
                                $model->delivery->deliveryMethodsList(),
                                ['prompt' => '--- Select ---']
                            ) ?>
                            <?= $form->field($model->delivery, 'index')->textInput() ?>
                            <?= $form->field($model->delivery, 'address')->textarea(['rows' => 1]) ?>
                    </div>
                    <div class="col-md-6 form-group">
                        <?= $form->field($model, 'note')->textarea(['rows' => 1]) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-secondary mb-5">
                <div class="card-header bg-secondary border-0">
                    <h4 class="font-weight-semi-bold m-0">Order Total</h4>
                </div>
                <div class="card-body">
                    <h5 class="font-weight-medium mb-3">Products</h5>
                    <table class="table table-borderless">
                        <tbody>
                        <?php
                        foreach ($cart->getItems() as $item): ?>
                            <?php
                            $product = $item->getProduct();
                            $modification = $item->getModification();
                            $url = Url::to(['/shop/catalog/product', 'id' => $product->id]);
                            ?>
                            <tr>
                                <td><?= Html::encode($product->name) ?>
                                    <?php
                                    if ($modification): ?>
                                    (<?= Html::encode($modification->name) ?>)
                                </td>
                                <?php
                                endif; ?>
                                <td> <?= $item->getQuantity() ?> pc.</td>
                                <td><?= PriceHelper::format($item->getPrice()) ?> </td>
                                <td><?= PriceHelper::format($item->getCost()) ?></td>
                            </tr>
                        <?php
                        endforeach; ?>
                        </tbody>
                    </table>
                    <hr class="mt-0">
                    <div class="d-flex justify-content-between mb-3 pt-1">
                        <?php $cost = $cart->getCost() ?>
                        <h6 class="font-weight-medium">Subtotal</h6>
                        <h6 class="font-weight-medium"><?= PriceHelper::format($cost->getOrigin()) ?></h6>
                    </div>
                    <div class="d-flex justify-content-between mb-3 pt-1">
                        <h6 class="font-weight-medium">Shipping</h6>
                        <h6 class="font-weight-medium"><?= WeightHelper::format($cart->getWeight()) ?></h6>
                    </div>
                    <!--<div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Shipping</h6>
                        <h6 class="font-weight-medium">$10</h6>
                    </div>-->
                </div>
                <div class="card-footer border-secondary bg-transparent">
                    <div class="d-flex justify-content-between mt-2">
                        <h5 class="font-weight-bold">Total</h5>
                        <h5 class="font-weight-bold"><?= PriceHelper::format($cost->getTotal()) ?></h5>
                    </div>
                </div>
                <div class="card-footer border-secondary bg-transparent">
                    <div class="d-flex justify-content-between mt-2">
                        <?= Html::submitButton('Place Order', ['class' => 'btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    ActiveForm::end() ?>
</div>
<!-- Checkout End -->