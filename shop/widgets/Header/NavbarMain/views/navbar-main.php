<?php



/* @var $this \yii\web\View */
/* @var $url  */

use shop\widgets\Carousel\Header\HeaderCarousel;
use shop\widgets\Header\NavbarCategories\NavbarCategories;
use shop\widgets\Header\NavbarMenu\NavbarMenu;

$active = Yii::$app->controller->id;

?>

<!-- Navbar Start -->
    <div class="container-fluid mb-5">
        <div class="row border-top px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100"
                   data-toggle="collapse" href="#navbar-vertical"
                   style="height: 65px; margin-top: -1px; padding: 0 30px;">
                    <h6 class="m-0">Categories</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse show navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0" id="navbar-vertical">
                    <?= NavbarCategories::widget()?>
                </nav>
            </div>
            <div class="col-lg-9">
                <?= NavbarMenu::widget()?>
                <?= HeaderCarousel::widget(['url' => $url]) ?>
            </div>
        </div>
    </div>
    <!-- Navbar End -->

