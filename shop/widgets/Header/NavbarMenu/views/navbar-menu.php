<?php



/* @var $this \yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$active = Yii::$app->controller->id;
?>
<nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
    <a href="" class="text-decoration-none d-block d-lg-none">
        <h1 class="m-0 display-5 font-weight-semi-bold"><span
                class="text-primary font-weight-bold border px-3 mr-1">E</span><?= Yii::$app->name ?>
        </h1>
    </a>
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
        <div class="navbar-nav mr-auto py-0">
            <?= Html::a(
                Html::encode('Home'),
                Url::home(),
                ['class' => $active == 'site' ? 'nav-item nav-link active' : 'nav-item nav-link ']
            ) ?>
            <?= Html::a(
                Html::encode('Shop'),
                Url::to(['/shop/catalog/index']),
                ['class' => $active == 'shop/catalog' ? 'nav-item nav-link active' : 'nav-item nav-link ']
            ) ?>
            <!--<a href="detail.html" class="nav-item nav-link">Shop Detail</a>-->
            <div class="nav-item dropdown">
                <a href="#" class="<?=$active == 'shop/cart' ? 'nav-link active': 'nav-link';?>" data-toggle="dropdown">Pages</a>
                <div class="dropdown-menu rounded-0 m-0">
                    <?= Html::a(
                        Html::encode('Shopping Cart'),
                        Url::to(['/shop/cart/index']),
                        ['class' => $active == 'shop/cart' ? 'dropdown-item active' : 'dropdown-item']
                    ) ?>
                    <?= Html::a(
                        Html::encode('Checkout'),
                        Url::to(['/shop/checkout/index']),
                        ['class' => $active == 'shop/checkout' ? 'dropdown-item active' : 'dropdown-item']
                    ) ?>
                </div>
            </div>
            <a href="contact.html" class="nav-item nav-link">Contact</a>
        </div>
        <?
        if (Yii::$app->user->isGuest): ?>
            <div class="navbar-nav ml-auto py-0">
                <?= Html::a(
                    Html::encode('Login'),
                    Url::to(['/auth/auth/login']),
                    ['class' => $active == 'auth/login' ? 'nav-item nav-link active' : 'nav-item nav-link']
                ) ?>
                <?= Html::a(
                    Html::encode('Register'),
                    Url::to(['/auth/signup/signup']),
                    ['class' => $active == 'auth/signup' ? 'nav-item nav-link active' : 'nav-item nav-link']
                ) ?>
            </div>
        <?
        else: ?>
            <div class="navbar-nav ml-auto py-0">
                <?= Html::a(
                    Html::encode('Cabinet ('. Yii::$app->user->identity->getUsername() .')'),
                    Url::to(['/cabinet/order/index']),
                    ['class' => $active == 'cabinet/order' ? 'nav-item nav-link active' : 'nav-item nav-link']
                ) ?>
                <?= Html::a(
                    'Logout',
                    ['/auth/auth/logout'],
                    ['data-method' => 'post', 'title' => 'logout',
                        'class' => $active == 'auth/logout' ? 'nav-item nav-link active' : 'nav-item nav-link']
                ) ?>
            </div>
        <?
        endif; ?>
    </div>
</nav>
