<?php

use frontend\assets\BlogAsset;
use frontend\widgets\Blog\LastPostsWidget;
use frontend\widgets\Product\FeaturedProductsWidget;
use frontend\widgets\Cart\Shop\CartWidget;


/* @var $this \yii\web\View */
/* @var $content string */
\shop\assets\AppAsset::register($this);


?>
<?php
$this->beginContent('@shop/views/layouts/main.php') ?>


<?/*= LastPostsWidget::widget(
    [
        'limit' => 4,
    ]
) */?><!--

<?/*= FeaturedProductsWidget::widget([
                                       'limit' => 4,
                                   ]) */?>

--><?/*= CartWidget::widget() */?>
<?= $content ?>


<?php
$this->endContent() ?>