<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \core\forms\Shop\AddToCartForm */

use yii\bootstrap4\ActiveForm;

$this->title = 'Add ' . $model->product->name;
$this->params['breadcrumbs'][] = ['label' => 'Catalog', 'url' => ['/shop/catalog/index']];
$this->params['breadcrumbs'][] = ['label' => 'Cart', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<!-- Shop Detail Start -->
<div class="container-fluid py-md-5">
    <div class="row px-xl-5">
        <div class="col-lg-5 pb-5">

    </div>
        <div class="col-lg-7 pb-5">
        <?php
        $form = ActiveForm::begin() ?>

            <h3 class="font-weight-semi-bold"><?= $model->product->name?></h3>
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
            <h3 class="font-weight-semi-bold mb-4"><?= $model->product->price_new;?></h3>
            <p class="mb-4"><?=$model->product->description; ?></p>
            <div class="d-flex mb-4">
                <?php
                if ($modifications = $model->modificationsList()): ?>
                    <?= $form->field($model, 'modification')->dropDownList(
                        $modifications,
                        ['prompt' => '--- Select ---']
                    ) ?>
                <?php
                endif; ?>

            </div>
            <div class="d-flex align-items-center mb-4 pt-2">
                <div class="input-group quantity-add mr-3" style="width: 130px;">

                    <div class="input-group-btn">
                        <span class="btn btn-primary btn-minus">
                            <i class="fa fa-minus"></i>
                        </span>
                    </div>

                    <input type="text" name="AddToCartForm[quantity]" class="form-control bg-secondary text-center" value="1">

                    <div class="input-group-btn">
                        <span class="btn btn-primary btn-plus">
                            <i class="fa fa-plus"></i>
                        </span>
                    </div>

                </div>
                <button class="btn btn-primary px-3"><i class="fa fa-shopping-cart mr-1"></i> Add To Cart</button>
            </div>
            <!--<div class="d-flex pt-2">
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
            </div>-->
            <?php
            ActiveForm::end() ?>
        </div>
    </div>
</div>
<!-- Shop Detail End -->