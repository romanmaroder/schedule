<?php

/* @var $this yii\web\View */
/* @var $product \core\entities\Shop\Product\Product */
/* @var $cartForm \core\forms\Shop\AddToCartForm */
/* @var $reviewForm \core\forms\Shop\ReviewForm*/


use core\helpers\PriceHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $product->name;

$this->registerMetaTag(['name' =>'description', 'content' => $product->meta->description]);
$this->registerMetaTag(['name' =>'keywords', 'content' => $product->meta->keywords]);

$this->params['breadcrumbs'][] = ['label' => 'Catalog', 'url' => ['index']];
foreach ($product->category->parents as $parent) {
    if (!$parent->isRoot()) {
        $this->params['breadcrumbs'][] = ['label' => $parent->name, 'url' => ['category', 'id' => $parent->id]];
    }
}
$this->params['breadcrumbs'][] = [
    'label' => $product->category->name,
    'url' => ['category', 'id' => $product->category->id]
];
$this->params['breadcrumbs'][] = $product->name;

$this->params['active_category'] = $product->category;

?>
    <!-- Shop Detail Start -->
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 pb-5">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner border">
                        <?php
                        foreach ($product->photos as $i => $photo): ?>
                            <?php
                            if ($i == 0): ?>
                                <div class="carousel-item active">
                                    <a class="thumbnail"
                                       href="<?= $photo->getThumbFileUrl('file', 'catalog_origin') ?>">
                                        <img class="w-100 h-100"
                                             src="<?= $photo->getThumbFileUrl('file', 'catalog_product_main') ?>"
                                             alt="<?= Html::encode($product->name) ?>"/>
                                    </a>
                                </div>
                            <?php
                            else: ?>
                                <div class="carousel-item">
                                    <a class="thumbnail" href="<?= $photo->getThumbFileUrl('file', 'catalog_origin') ?>"
                                       title="HP LP3065">
                                        <img class="w-100 h-100"
                                             src="<?= $photo->getThumbFileUrl('file', 'catalog_product_additional') ?>"
                                             alt=""/>
                                    </a>
                                </div>
                            <?php
                            endif; ?>
                        <?php
                        endforeach; ?>

                        <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                            <i class="fa fa-2x fa-angle-left text-dark"></i>
                        </a>
                        <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                            <i class="fa fa-2x fa-angle-right text-dark"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 pb-5">
                <h3 class="font-weight-semi-bold"><?= Html::encode($product->name) ?></h3>
                <div class="d-flex mb-3">
                    <div class="text-primary mr-2">
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star-half-alt"></small>
                        <small class="far fa-star"></small>
                    </div>
                    <small class="pt-1">(50 Reviews)</small>
                </div>
                <h3 class="font-weight-semi-bold mb-4"><?= PriceHelper::format($product->price_new) ?></h3>
                <p class="mb-4"><?= Yii::$app->formatter->asHtml(
                        $product->description,
                        [
                            'Attr.AllowedRel' => array('nofollow'),
                            'HTML.SafeObject' => true,
                            'Output.FlashCompat' => true,
                            'HTML.SafeIframe' => true,
                            'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                        ]
                    ) ?></p>
                <div class="d-flex mb-4">
                    <p class="text-dark font-weight-medium mb-0 mr-3">Brand:
                        <a href="<?= Html::encode(Url::to(['brand', 'id' => $product->brand->id])) ?>">
                            <?= Html::encode($product->brand->name) ?>
                        </a>
                    </p>
                    <p class="text-dark font-weight-medium mb-0 mr-3">
                        Tags:
                        <?php
                        foreach ($product->tags as $tag): ?>
                            <a href="<?= Html::encode(Url::to(['tag', 'id' => $tag->id])) ?>"><?= Html::encode(
                                    $tag->name
                                ) ?></a>
                        <?php
                        endforeach; ?>
                    </p>
                    <p>Product Code: <?= Html::encode($product->code) ?></p>
                </div>
                <div class="d-flex align-items-center mb-4 pt-2" id="product">

                        <?php if ($product->isAvailable()): ?>
                            <?php $form = ActiveForm::begin( [
                                                                 'fieldConfig' => [
                                                                     'options' => [
                                                                         'class' => 'mb-0'
                                                                     ]
                                                                 ],
                                'action' => ['/shop/cart/add', 'id' => $product->id],
                            ] ) ?>
                    <div class="d-flex mb-4">
                                <?php if ($modifications = $cartForm->modificationsList()): ?>
                                <?= $form->field($cartForm, 'modification')->dropDownList(
                                        $modifications,
                                        ['prompt' => '--- Select ---']
                                    ) ?>
                                <?php endif; ?>
                    </div>
                    <div class="d-flex align-items-center mb-4 pt-2">
                                <?= $form->field( $cartForm,'quantity',
                                    [
                                        'template' => '<div class="input-group quantity-add mr-3" style="width: 150px;">
                                                    <div class="input-group-btn">
                                                        <span class="btn btn-primary btn-minus">
                                                            <i class="fa fa-minus"></i>
                                                        </span>
                                                    </div>
                                                    {input}
                                                    <div class="input-group-btn">
                                                        <span class="btn btn-primary btn-plus">
                                                            <i class="fa fa-plus"></i>
                                                        </span>
                                                    </div>
                                                    {error}
                                                </div>'
                                    ]
                                )->textInput(['class' => 'form-control text-center'])->label(false) ?>
                                <?= Html::submitButton(
                                    '<i class="fa fa-shopping-cart mr-1"></i> Add To Cart',
                                    ['class' => 'btn btn-primary px-3']
                                ) ?>
                    </div>
                            <?php ActiveForm::end() ?>

                        <?php else: ?>
                            <div class="alert alert-danger">
                                The product is not available for purchasing right now.<br/>Add it to your wishlist.
                            </div>
                        <?php  endif; ?>
                </div>

                <div class="">
                    <a href="" onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;">0 reviews</a> /
                    <a href="" onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;">Write a review</a>

                </div>
                <!-- AddThis Button BEGIN -->
                <!--<div class="addthis_toolbox addthis_default_style" data-url="/index.php?route=product/product&amp;product_id=47">
                    <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                    <a class="addthis_button_tweet"></a> <a class="addthis_button_pinterest_pinit"></a>
                    <a class="addthis_counter addthis_pill_style"></a>
                </div>
                <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-515eeaf54693130e"></script>-->
                <!-- AddThis Button END -->

                <div class="d-flex pt-2">
                    <p class="text-dark font-weight-medium mb-0 mr-2">Share on:</p>
                    <div class="d-inline-flex">
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-pinterest"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                    <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Description</a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-2">Information</a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-review">Reviews (0)</a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-pane-1">
                        <h4 class="mb-3">Product Description</h4>
                        <?= Yii::$app->formatter->asHtml(
                            $product->description,
                            [
                                'Attr.AllowedRel' => array('nofollow'),
                                'HTML.SafeObject' => true,
                                'Output.FlashCompat' => true,
                                'HTML.SafeIframe' => true,
                                'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                            ]
                        ) ?>
                    </div>
                    <div class="tab-pane fade" id="tab-pane-2">
                        <h4 class="mb-3">Additional Information</h4>
                        <table class="table table-bordered">
                            <tbody>
                            <?php
                            foreach ($product->values as $value): ?>
                                <?php
                                if (!empty($value->value)): ?>
                                    <tr>
                                        <th><?= Html::encode($value->characteristic->name) ?></th>
                                        <td><?= Html::encode($value->value) ?></td>
                                    </tr>
                                <?php
                                endif; ?>
                            <?php
                            endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="tab-review">
                        <div class="row">
                            <div class="col-md-6">
                                <div id="review"></div>
                                <h4 class="mb-4">1 review for "Colorful Stylish Shirt"</h4>
                                <div class="media mb-4">
                                    <?= Html::img(
                                        ['/img/user.jpg'],
                                        [
                                            'alt' => 'Image',
                                            'class' => 'img-fluid mr-3 mt-1',
                                            'style' => 'width: 45px'
                                        ]
                                    ) ?>
                                    <div class="media-body">
                                        <h6>John Doe<small> - <i>01 Jan 2045</i></small></h6>
                                        <div class="text-primary mb-2">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                            <i class="far fa-star"></i>
                                        </div>
                                        <p>Diam amet duo labore stet elitr ea clita ipsum, tempor labore accusam ipsum
                                            et no at. Kasd diam tempor rebum magna dolores sed sed eirmod ipsum.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4 class="mb-4">Leave a review</h4>
                                <small>Your email address will not be published. Required fields are marked *</small>
                                <div class="d-flex my-3">
                                    <p class="mb-0 mr-2">Your Rating * :</p>
                                    <!--<div class="text-primary">
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>-->
                                </div>
                                <?php
                                if (Yii::$app->user->isGuest): ?>

                                    <div class="panel-panel-info">
                                        <div class="panel-body">
                                            Please <?= Html::a('Log In', ['/auth/auth/login']) ?> for writing a review.
                                        </div>
                                    </div>

                                <?php
                                else: ?>

                                    <?php
                                    $form = ActiveForm::begin(['id' => 'form-review']) ?>
                                    <div class="form-group">
                                        <?= $form->field($reviewForm, 'vote')->dropDownList(
                                            $reviewForm->votesList(),
                                            ['prompt' => 'Select']
                                        )->label(false) ?>
                                    </div>
                                    <div class="form-group">
                                        <?= $form->field($reviewForm, 'text')->textarea(['rows' => 5]) ?>
                                    </div>
                                    <div class="form-group mb-0">
                                        <?= Html::submitButton(
                                            'Leave Your Review',
                                            ['class' => 'btn btn-primary px-3']
                                        ) ?>
                                    </div>

                                    <?php
                                    ActiveForm::end() ?>

                                <?php
                                endif; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->
