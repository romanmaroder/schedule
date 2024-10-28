<?php
/* @var $content string */

/* @var $url string */

/* @var $class string */

use shop\widgets\Header\HeaderStart\HeaderStart;
use shop\widgets\Header\NavbarMain\NavbarMain;
use shop\widgets\Header\NavbarOther\NavbarOther;


?>
<div class="content-wrapper">
   <?php
    if ($url == 'site/index'): ?>
        <?= NavbarMain::widget(['url' => $url]) ?>
    <?php else: ?>
        <?/*= NavbarOther::widget(['url' => $url]) */?>
    <? endif; ?>

    <?= HeaderStart::widget(['url' => $url, 'title' => Yii::$app->getView()->title]) ?>
    <!-- Main content -->
    <div class="content">
        <?= $content ?>
    </div>
    <!-- /.content -->
</div>