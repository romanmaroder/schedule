<?php

/* @var $category \core\entities\Shop\Product\Category */

use yii\helpers\Html;
use yii\helpers\Url;

?>

<?php if ($category->children): ?>

    <div class="col-lg-3 col-md-12">
        <nav class="navbar-vertical">
            <div class="navbar-nav w-100 overflow-hidden"></div>
            <?php foreach ($category->children as $child): ?>
                <a href="<?= Html::encode(Url::to(['/shop/catalog/category', 'id' => $child->id])) ?>" class="nav-item nav-link"><?= Html::encode($child->name) ?></a>
            <?php endforeach; ?>
        </nav>
    </div>

<?php endif; ?>