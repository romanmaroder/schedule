<?php

/* @var $this yii\web\View */
/* @var $product \core\entities\Shop\Product\Product*/

use core\helpers\PriceHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$url = Url::to(['product', 'id' =>$product->id]);

?>

<div class="col-lg-4 col-md-6 col-sm-12 pb-1">
    <div class="card product-item border-0 mb-4">
        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
            <?php
            if ($product->mainPhoto): ?>
                <img class="img-fluid w-100" src="<?= Html::encode(
                    $product->mainPhoto->getThumbFileUrl('file', 'catalog_product_main')
                ) ?>" alt="">
            <?php
            endif; ?>
        </div>
        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
            <h6 class="text-truncate mb-3"><?= Html::encode($product->name) ?>
                <button type="button"
                        data-toggle="tooltip"
                        title="Add to Wish List"
                    <?
                    /*= $product->wishlistItems ? '' : "href=" . Url::to(
                                                ['/cabinet/default/wishlist-add', 'id' => $product->id]
                                            ) */ ?>
                        href=" <?= Url::to(['/cabinet/default/wishlist-add', 'id' => $product->id]) ?>"
                        data-method="post"
                        class="btn btn-sm text-dark p-0 ml-2">
                    <i class="<?= $product->wishlistItems ? "fas fa-heart text-primary mr-1" : "far fa-heart text-primary mr-1" ?>"></i>
                </button>
            </h6>
            <div class="d-flex justify-content-center">
                <h6>$<?= PriceHelper::format($product->price_new) ?></h6>
                <?
                if ($product->price_old): ?>
                    <h6 class="text-muted ml-2">
                        <del>$<?= PriceHelper::format($product->price_old) ?></del>
                    </h6>
                <?
                endif; ?>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between bg-light border">
            <button type="button"
                    data-toggle="tooltip"
                    title="View Detail"
                    href="<?= Html::encode($url) ?>"
                    data-method="post"
                    class="btn btn-sm text-dark p-0">
                <i class="fas fa-eye text-primary mr-1"></i>
                <span class="hidden-xs hidden-sm hidden-md">View Detail</span>
            </button>

            <!--<button type="button"
                    data-toggle="tooltip"
                    title="Add to Wish List"
                <?/*= $product->wishlistItems ? '' : "href=" . Url::to(
                        ['/cabinet/default/wishlist-add', 'id' => $product->id]
                    ) */?>
                    data-method="post"
                    class="btn btn-sm text-dark p-0">
                <i class="<?/*= $product->wishlistItems ? "fas fa-heart text-primary mr-1" : "far fa-heart text-primary mr-1" */?>"></i>
            </button>-->

            <button type="button"
                    href="<?= Url::to(['/shop/cart/add', 'id' => $product->id]) ?>"
                    data-method="post"
                    class="btn btn-sm text-dark p-0">
                <i class="fas fa-shopping-cart text-primary mr-1"></i>
                <span class="hidden-xs hidden-sm hidden-md">Add to Cart</span>
            </button>
        </div>
    </div>
</div>