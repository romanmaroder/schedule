<?php

use frontend\widgets\Blog\LastPostsWidget;

/* @var $this \yii\web\View */
/* @var $content string */


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