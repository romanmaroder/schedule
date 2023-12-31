<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;

?>
<?php $this->beginContent('@frontend/views/layouts/main.php') ?>
<div class="container-fluid">
    <div class="row">
        <div id="content" class="col-sm-9">
            <?= $content ?>
        </div>
        <aside id="column-right" class="col-sm-3 hidden-xs">
            <div class="list-group">
                <a href="<?= Html::encode(Url::to(['/auth/auth/login'])) ?>" class="list-group-item">Login</a>
                <a href="<?= Html::encode(Url::to(['/auth/signup/signup'])) ?>" class="list-group-item">Signup</a>
                <a href="<?= Html::encode(Url::to(['/auth/reset/request-password-reset'])) ?>" class="list-group-item">Forgotten Password</a>
                <a href="/account/wishlist" class="list-group-item">Wish List</a>
                <a href="/account/order" class="list-group-item">Order History</a>
                <a href="/account/newsletter" class="list-group-item">Newsletter</a>
            </div>
        </aside>
    </div>
</div>
<?php $this->endContent() ?>