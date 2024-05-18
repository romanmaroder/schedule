<?php

/* @var $this \yii\web\View */

/* @var $content string */

use frontend\widgets\Blog\CategoriesWidget;

?>
<?php
$this->beginContent('@frontend/views/layouts/main.php') ?>

<div class="site-section pt-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 single-content">
                <?= $content ?>
            </div>

            <div class="col-lg-3 ml-auto mt-3 mt-lg-0">
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



<?php
$this->endContent() ?>