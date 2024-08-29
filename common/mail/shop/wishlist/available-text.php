<?php

/* @var $this yii\web\View */
/* @var $user \core\entities\User\User */
/* @var $product \core\entities\Shop\Product\Product */

$link = Yii::$app->get('frontendUrlManager')->createAbsoluteUrl(['shop/catalog/product', 'id' => $product->id]);
?>
    Hello <?= $user->username ?>,

    Product from your wishlist is available right now:

<?= $link ?>