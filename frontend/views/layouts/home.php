<?php

use frontend\assets\BlogAsset;
use frontend\widgets\Blog\LastPostsWidget;

/* @var $this \yii\web\View */
/* @var $content string */

BlogAsset::register($this);
?>
<?php
$this->beginContent('@frontend/views/layouts/main.php') ?>


<?= LastPostsWidget::widget(
    [
        'limit' => 4,
    ]
) ?>
<?= $content ?>


<?php
$this->endContent() ?>