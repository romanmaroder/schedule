<?php

/* @var $this \yii\web\View */

/* @var $content string */

use shop\assets\BlogAsset;
use shop\widgets\Blog\CategoriesWidget;

BlogAsset::register($this);

?>
<?php
$this->beginContent('@shop/views/layouts/main.php') ?>

<div class="site-section pt-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 single-content">
                <?= $content ?>
            </div>

            <div class="col-lg-3 ml-auto mt-3 mt-lg-0">
                <div class="sticky-top pt-2">
                    <div class="section-title">
                        <h2>Popular Posts</h2>
                    </div>
                    <?= CategoriesWidget::widget(
                        [
                            'active' => $this->params['active_category'] ?? null
                        ]
                    )  ?>
                </div>
            </div>
        </div>
    </div>
</div>



<?php
$this->endContent() ?>
