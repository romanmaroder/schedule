<?php



/* @var $this \yii\web\View */
/* @var $cart \core\cart\shop\Cart */
/* @var $model \core\forms\Shop\Order\OrderForm */

use core\helpers\PriceHelper;
use core\helpers\WeightHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Checkout';
$this->params['breadcrumbs'][] = ['label' => 'Catalog', 'url' => ['/shop/catalog/index']];
$this->params['breadcrumbs'][] = ['label' => 'Shopping Cart', 'url' => ['/shop/cart/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cabinet-index">

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <td class="text-left">Product Name</td>
                <td class="text-left">Model</td>
                <td class="text-left">Quantity</td>
                <td class="text-right">Unit Price</td>
                <td class="text-right">Total</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($cart->getItems() as $item): ?>
                <?php
                $product = $item->getProduct();
                $modification = $item->getModification();
                $url = Url::to(['/shop/catalog/product', 'id' => $product->id]);
                ?>
                <tr>
                    <td class="text-left">
                        <a href="<?= $url ?>"><?= Html::encode($product->name) ?></a>
                    </td>
                    <td class="text-left">
                        <?php if ($modification): ?>
                            <?= Html::encode($modification->name) ?>
                        <?php endif; ?>
                    </td>
                    <td class="text-left">
                        <?= $item->getQuantity() ?>
                    </td>
                    <td class="text-right"><?= PriceHelper::format($item->getPrice()) ?></td>
                    <td class="text-right"><?= PriceHelper::format($item->getCost()) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <br />

    <?php $cost = $cart->getCost() ?>
    <table class="table table-bordered">
        <tr>
            <td class="text-right"><strong>Sub-Total:</strong></td>
            <td class="text-right"><?= PriceHelper::format($cost->getOrigin()) ?></td>
        </tr>
        <tr>
            <td class="text-right"><strong>Total:</strong></td>
            <td class="text-right"><?= PriceHelper::format($cost->getTotal()) ?></td>
        </tr>
        <tr>
            <td class="text-right"><strong>Weight:</strong></td>
            <td class="text-right"><?= WeightHelper::format($cart->getWeight()) ?></td>
        </tr>
    </table>

    <?php $form = ActiveForm::begin() ?>

    <div class="panel panel-default">
        <div class="panel-heading">Customer</div>
        <div class="panel-body">
            <?= $form->field($model->customer, 'phone')->textInput() ?>
            <?= $form->field($model->customer, 'name')->textInput() ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">Delivery</div>
        <div class="panel-body">
            <?= $form->field($model->delivery, 'method')->dropDownList($model->delivery->deliveryMethodsList(), ['prompt' => '--- Select ---']) ?>
            <?= $form->field($model->delivery, 'index')->textInput() ?>
            <?= $form->field($model->delivery, 'address')->textarea(['rows' => 3]) ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">Note</div>
        <div class="panel-body">
            <?= $form->field($model, 'note')->textarea(['rows' => 3]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Checkout', ['class' => 'btn btn-sm btn-shadow dtn-gradient btn-primary btn-block']) ?>
    </div>

    <?php ActiveForm::end() ?>

</div>


<!-- Checkout Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <div class="col-lg-8">
            <div class="mb-4">
                <h4 class="font-weight-semi-bold mb-4">Billing Address</h4>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>First Name</label>
                        <input class="form-control" type="text" placeholder="John">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Last Name</label>
                        <input class="form-control" type="text" placeholder="Doe">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>E-mail</label>
                        <input class="form-control" type="text" placeholder="example@email.com">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Mobile No</label>
                        <input class="form-control" type="text" placeholder="+123 456 789">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Address Line 1</label>
                        <input class="form-control" type="text" placeholder="123 Street">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Address Line 2</label>
                        <input class="form-control" type="text" placeholder="123 Street">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Country</label>
                        <select class="custom-select">
                            <option selected>United States</option>
                            <option>Afghanistan</option>
                            <option>Albania</option>
                            <option>Algeria</option>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>City</label>
                        <input class="form-control" type="text" placeholder="New York">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>State</label>
                        <input class="form-control" type="text" placeholder="New York">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>ZIP Code</label>
                        <input class="form-control" type="text" placeholder="123">
                    </div>
                    <div class="col-md-12 form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="newaccount">
                            <label class="custom-control-label" for="newaccount">Create an account</label>
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="shipto">
                            <label class="custom-control-label" for="shipto"  data-toggle="collapse" data-target="#shipping-address">Ship to different address</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="collapse mb-4" id="shipping-address">
                <h4 class="font-weight-semi-bold mb-4">Shipping Address</h4>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>First Name</label>
                        <input class="form-control" type="text" placeholder="John">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Last Name</label>
                        <input class="form-control" type="text" placeholder="Doe">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>E-mail</label>
                        <input class="form-control" type="text" placeholder="example@email.com">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Mobile No</label>
                        <input class="form-control" type="text" placeholder="+123 456 789">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Address Line 1</label>
                        <input class="form-control" type="text" placeholder="123 Street">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Address Line 2</label>
                        <input class="form-control" type="text" placeholder="123 Street">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Country</label>
                        <select class="custom-select">
                            <option selected>United States</option>
                            <option>Afghanistan</option>
                            <option>Albania</option>
                            <option>Algeria</option>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>City</label>
                        <input class="form-control" type="text" placeholder="New York">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>State</label>
                        <input class="form-control" type="text" placeholder="New York">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>ZIP Code</label>
                        <input class="form-control" type="text" placeholder="123">
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
            </div>
            <div class="card border-secondary mb-5">
                <div class="card-header bg-secondary border-0">
                    <h4 class="font-weight-semi-bold m-0">Payment</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="payment" id="paypal">
                            <label class="custom-control-label" for="paypal">Paypal</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="payment" id="directcheck">
                            <label class="custom-control-label" for="directcheck">Direct Check</label>
                        </div>
                    </div>
                    <div class="">
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="payment" id="banktransfer">
                            <label class="custom-control-label" for="banktransfer">Bank Transfer</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-secondary bg-transparent">
                    <button class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Place Order</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Checkout End -->