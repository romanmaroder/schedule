<?php

/* @var $this yii\web\View */
/* @var $product \core\entities\Shop\Product\Product */
/* @var $cartForm \core\forms\Shop\AddToCartForm */
/* @var $reviewForm \core\forms\Shop\ReviewForm*/


use core\helpers\PriceHelper;
use kartik\widgets\StarRating;
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
                        <?php
                        echo StarRating::widget(
                            [
                                'name' => 'vidget',
                                'value' => $product->rating,
                                'pluginOptions' => [
                                    'step' => 1,
                                    'theme' => 'krajee-fas',
                                    'size' => 'xs',
                                    'readonly' => true,
                                    'showClear' => false,
                                    'showCaption' => false,
                                    'filledStar' => '<i class="fas fa-star text-primary"></i>',
                                    'emptyStar' => '<i class="far fa-star text-primary"></i>'
                                ],

                            ]
                        ); ?>
                    </div>
                    <a href="" onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;"><small class="text-dark">(<?= $product->countReview() ?> reviews)</small></a>
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
                                                                         'class' => 'mb-0',
                                                                     ]
                                                                 ],
                                'action' => ['/shop/cart/add-catalog', 'id' => $product->id],
                            ] ) ?>
                    <div class="d-flex mb-4">
                                <?php if ($modifications = $cartForm->modificationsList()): ?>
                                    <?= $form->field($cartForm, 'modification')->dropDownList(
                                        $modifications,
                                        ['prompt' => '--- Select ---']
                                    ) ?>

                                <?php endif; ?>
                    </div>
                    <div class="d-flex align-items-center mb-2 pt-2">
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
                <div class="d-flex">
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
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-review">Reviews (<?= $product->countReview() ?>)</a>
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
                                <h4 class="mb-4"><?= $product->countReview() ?> review for "<?= $product->name; ?>"</h4>
                                <?php
                                foreach ($product->reviews as $i => $review) : ?>
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
                                            <h6><?= $review->user->username; ?><small> -
                                                    <i><?= Yii::$app->formatter->asDate(
                                                            $review->created_at,
                                                            'd MMM Y'
                                                        ) ?></i></small></h6>
                                            <div class="text-primary mb-2">
                                                <?php
                                                echo StarRating::widget(
                                                    [
                                                        'name' => 'vote',
                                                        'value' => $review->vote,
                                                        'pluginOptions' => [
                                                            'step' => 1,
                                                            'theme' => 'krajee-fas',
                                                            'size' => 'xs',
                                                            'readonly' => true,
                                                            'showClear' => false,
                                                            'showCaption' => false,
                                                            'filledStar' => '<i class="fas fa-star text-primary"></i>',
                                                            'emptyStar' => '<i class="far fa-star text-primary"></i>'
                                                        ],

                                                    ]
                                                ); ?>
                                            </div>
                                            <p><?= $review->text; ?></p>
                                        </div>
                                    </div>
                                <?php
                                endforeach; ?>
                            </div>
                            <div class="col-md-6">
                                <h4 class="mb-4">Leave a review</h4>
                                <small>Your email address will not be published. Required fields are marked *</small>
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
                                    <div class="d-flex my-3">
                                        <p class="mb-0 mr-2">Your Rating * :
                                            <span class="form-group">
                                                <?/*= $form->field($reviewForm, 'vote')->dropDownList(
                                                            $reviewForm->votesList(),
                                                            ['prompt' => 'Select']
                                                        )->label(false) */ ?>

                                                <?= $form->field($reviewForm, 'vote',)->widget(
                                                    StarRating::class,
                                                    [
                                                        'name' => 'vote',
                                                        'pluginOptions' => [
                                                            'step' => 1,
                                                            'containerClass'=>'rating-custom',
                                                            'stars' => count($reviewForm->votesList()),
                                                            'theme' => 'krajee-fas',
                                                            'size' => 'xs',
                                                            'readonly' => false,
                                                            'showClear' => false,
                                                            'showCaption' => false,
                                                            'filledStar' => '<i class="fas fa-star text-primary"></i>',
                                                            'emptyStar' => '<i class="far fa-star text-primary"></i>',
                                                        ],

                                                    ]
                                                )->label(false); ?>
                                            </span>
                                        </p>
                                    </div>


                                    <div class="form-group">
                                        <?= $form->field($reviewForm, 'text')->textarea(['rows' => 5])->label(
                                            'Your Review *'
                                        ) ?>
                                        <?= $form->field($reviewForm, 'userId')->hiddenInput(
                                            ['value' => Yii::$app->user->id]
                                        )->label(false) ?>
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
