<?php

/* @var $this yii\web\View */
/* @var $cart \core\cart\shop\Cart */

use core\helpers\PriceHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Shopping Cart';
$this->params['breadcrumbs'][] = ['label' => 'Catalog', 'url' => ['/shop/catalog/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Cart Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-5">
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
                        <td class="align-middle">
                            <?php
                            if ($product->mainPhoto): ?>
                                <img src="<?= $product->mainPhoto->getThumbFileUrl('file', 'cart_list') ?>" alt=""
                                     style="width: 50px;" class="mr-2"/>
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

                            <!--<div class="input-group quantity mx-auto" style="width: 100px;">

                                <input type="text" name="quantity" value="<?/*= $item->getQuantity() */?>" size="1"
                                       class="form-control form-control-sm bg-secondary text-center"/>

                                <span class="input-group-btn">
                                    <button type="submit" title="" class="btn btn-primary" data-original-title="Update">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </span>

                            </div>-->

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
                <div class="card-header bg-secondary border-0">
                    <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3 pt-1">
                        <h6 class="font-weight-medium">Subtotal</h6>
                        <h6 class="font-weight-medium">$150</h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Shipping</h6>
                        <h6 class="font-weight-medium">$10</h6>
                    </div>
                </div>
                <div class="card-footer border-secondary bg-transparent">
                    <div class="d-flex justify-content-between mt-2">
                        <h5 class="font-weight-bold">Total</h5>
                        <h5 class="font-weight-bold">$160</h5>
                    </div>
                    <button class="btn btn-block btn-primary my-3 py-3">Proceed To Checkout</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart End -->
<!--<div class="cabinet-index">
    <h1><?
/*= Html::encode($this->title) */ ?></h1>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <td class="text-center" style="width: 100px">Image</td>
                <td class="text-left">Product Name</td>
                <td class="text-left">Model</td>
                <td class="text-left">Quantity</td>
                <td class="text-right">Unit Price</td>
                <td class="text-right">Total</td>
            </tr>
            </thead>
            <tbody>
            <?php
/*foreach ($cart->getItems() as $item): */ ?>
                <?php
/*                $product = $item->getProduct();
                $modification = $item->getModification();
                $url = Url::to(['/shop/catalog/product', 'id' => $product->id]);
                */ ?>
                <tr>
                    <td class="text-center">
                        <a href="<?
/*= $url */ ?>">
                            <?php
/*if ($product->mainPhoto): */ ?>
                                <img src="<?
/*= $product->mainPhoto->getThumbFileUrl('file', 'cart_list') */ ?>" alt="" class="img-thumbnail" />
                            <?php
/*endif; */ ?>
                        </a>
                    </td>
                    <td class="text-left">
                        <a href="<?
/*= $url */ ?>"><?
/*= Html::encode($product->name) */ ?></a>
                    </td>
                    <td class="text-left">
                        <?php
/*if ($modification): */ ?>
                            <?
/*= Html::encode($modification->name) */ ?>
                        <?php
/*endif; */ ?>
                    </td>
                    <td class="text-left">
                        <?
/*= Html::beginForm(['quantity', 'id' => $item->getId()]); */ ?>
                        <div class="input-group btn-block" style="max-width: 200px;">
                            <input type="text" name="quantity" value="<?
/*= $item->getQuantity() */ ?>" size="1" class="form-control" />
                            <span class="input-group-btn">
                                    <button type="submit" title="" class="btn btn-primary" data-original-title="Update"><i class="fas fa-sync-alt"></i></button>
                                    <a title="Remove" class="btn btn-danger" href="<?
/*= Url::to(['remove', 'id' => $item->getId()]) */ ?>" data-method="post"><i class="fa fa-times-circle"></i></a>
                                </span>
                        </div>
                        <?
/*= Html::endForm() */ ?>
                    </td>
                    <td class="text-right"><?
/*= PriceHelper::format($item->getPrice()) */ ?></td>
                    <td class="text-right"><?
/*= PriceHelper::format($item->getCost()) */ ?></td>
                </tr>
            <?php
/*endforeach; */ ?>
            </tbody>
        </table>
    </div>

    <br />
    <div class="row">
        <div class="col-sm-4 col-sm-offset-8">
            <?php
/*$cost = $cart->getCost() */ ?>
            <table class="table table-bordered">
                <tr>
                    <td class="text-right"><strong>Sub-Total:</strong></td>
                    <td class="text-right"><?
/*= PriceHelper::format($cost->getOrigin()) */ ?></td>
                </tr>
                <?php
/*foreach ($cost->getDiscounts() as $discount): */ ?>
                    <tr>
                        <td class="text-right"><strong><?
/*= Html::encode($discount->getName()) */ ?>:</strong></td>
                        <td class="text-right"><?
/*= PriceHelper::format($discount->getValue()) */ ?></td>
                    </tr>
                <?php
/*endforeach; */ ?>
                <tr>
                    <td class="text-right"><strong>Total:</strong></td>
                    <td class="text-right"><?
/*= PriceHelper::format($cost->getTotal()) */ ?></td>
                </tr>
                <tr>
                    <td class="text-right"><strong>Weight:</strong></td>
                    <td class="text-right"><?
/*= WeightHelper::format($cart->getWeight()) */ ?></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="buttons clearfix row">
        <div class="pull-left col-6"><a href="<?
/*= Url::to('/shop/catalog/index') */ ?>" class="btn btn-default">Continue Shopping</a></div>
        <?php
/*if ($cart->getItems()): */ ?>
            <div class="pull-right col-6"><a href="<?
/*= Url::to('/shop/checkout/index') */ ?>" class="btn btn-primary">Checkout</a></div>
        <?php
/*endif; */ ?>
    </div>
</div>-->