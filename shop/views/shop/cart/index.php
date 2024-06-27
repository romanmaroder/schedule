<?php

/* @var $this yii\web\View */
/* @var $cart \core\cart\shop\Cart */

use core\helpers\PriceHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Shopping Cart';
$this->params['breadcrumbs'][] = ['label' => 'Cabinet', 'url' => ['/shop/cabinet/order/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Cart Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-5">
            <? if ($cart->getItems()) :?>
            <table class="table table-bordered text-center mb-0">
                <thead class="bg-secondary text-dark">
                <tr>
                    <th>Products</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Remove</th>
                </tr>
                </thead>
                <tbody class="align-middle">
                <?php
                foreach ($cart->getItems() as $item): ?>
                    <?php
                    $product = $item->getProduct();
                    $modification = $item->getModification();
                    $url = Url::to(['/shop/catalog/product', 'id' => $product->id]);
                    ?>
                    <tr>
                        <td class="align-middle text-sm-left">
                            <?php
                            if ($product->mainPhoto): ?>
                                <img src="<?= $product->mainPhoto->getThumbFileUrl('file', 'cart_list') ?>" alt=""
                                     style="width: 50px;" class="mr-2 mb-2 mb-sm-0 shopping-img"/>
                            <?php
                            endif; ?>
                            <a href="<?= $url ?>">
                                <?= Html::encode($product->name) ?>
                                <?php
                                if ($modification): ?><small>(<?= Html::encode($modification->name) ?>)</small>
                                <?php
                                endif; ?>
                            </a>
                        </td>
                        <td class="align-middle"><?= PriceHelper::format($item->getPrice()) ?></td>
                        <td class="align-middle">
                            <?= Html::beginForm(['quantity', 'id' => $item->getId()]); ?>
                            <div class="input-group quantity mx-auto" style="width: 100px;">

                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-primary btn-minus">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>

                                <input type="text" name="quantity" class="form-control form-control-sm bg-secondary text-center"
                                       value="<?= $item->getQuantity() ?>">

                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-primary btn-plus">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>

                            <?= Html::endForm();?>
                        </td>

                        <td class="align-middle"><?= PriceHelper::format($item->getCost()) ?></td>
                        <td class="align-middle">
                            <button type="button"
                                    href="<?= Url::to(['remove', 'id' => $item->getId()]) ?>"
                                    data-method="post"
                                    class="btn btn-sm btn-primary">
                                <i class="fa fa-times"></i>
                                <!--<span class="hidden-xs hidden-sm hidden-md">Remove</span>-->
                            </button>
                        </td>
                    </tr>
                <?php
                endforeach; ?>
                </tbody>
            </table>
            <?else:?>
           <h2 class="font-weight-semi-bold text-uppercase mb-3 text-center text-primary ">Shopping cart is empty</h2>
            <?endif?>
        </div>
        <div class="col-lg-4">
            <!--<form class="mb-5" action="">
                <div class="input-group">
                    <input type="text" class="form-control p-4" placeholder="Coupon Code">
                    <div class="input-group-append">
                        <button class="btn btn-primary">Apply Coupon</button>
                    </div>
                </div>
            </form>-->
            <div class="card border-secondary mb-5">
                <?php $cost = $cart->getCost()  ?>
                <div class="card-header bg-secondary border-0">
                    <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3 pt-1">
                        <h6 class="font-weight-medium">Subtotal</h6>
                        <h6 class="font-weight-medium"><?= PriceHelper::format($cost->getOrigin())  ?></h6>
                    </div>
                    <div class="d-flex justify-content-between">
                    <?php foreach ($cost->getDiscounts() as $discount):  ?>
                        <h6 class="font-weight-medium">  <?= Html::encode($discount->getName())  ?></h6>
                        <h6 class="font-weight-medium"><?= PriceHelper::format($discount->getValue())  ?></h6>
                    <?php endforeach;  ?>
                    </div>
                </div>
                <div class="card-footer border-secondary bg-transparent">
                    <div class="d-flex justify-content-between mt-2">
                        <h5 class="font-weight-bold">Total</h5>
                        <h5 class="font-weight-bold">
                            <?= PriceHelper::format($cost->getTotal())?>
                        </h5>
                    </div>
                    <?php if ($cart->getItems()): ?>
                        <a href="<?= Url::to('/shop/checkout/index') ?>" class="btn btn-block btn-primary my-3 py-3">Proceed To Checkout</a>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart End -->
