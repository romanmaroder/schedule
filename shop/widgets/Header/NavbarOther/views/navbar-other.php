<?php



/* @var $this \yii\web\View */
/* @var $url  */

use shop\widgets\Header\NavbarCategories\NavbarCategories;
use shop\widgets\Header\NavbarMenu\NavbarMenu;

?>
<!-- Navbar Start -->
<div class="container-fluid">
    <div class="row border-top px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                <h6 class="m-0">Categories</h6>
                <i class="fa fa-angle-down text-dark"></i>
            </a>
            <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 1;">
                <?= NavbarCategories::widget()?>
            </nav>
        </div>
        <div class="col-lg-9">
            <?= NavbarMenu::widget()?>
        </div>
    </div>
</div>
<!-- Navbar End -->
