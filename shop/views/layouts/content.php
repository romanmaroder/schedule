<?php
/* @var $content string */

/* @var $url string */

/* @var $class string */

use shop\widgets\Header\HeaderStart\HeaderStart;
use shop\widgets\Header\NavbarMain\NavbarMain;
use shop\widgets\Header\NavbarOther\NavbarOther;

$classNavbarShow = '';
$classMarginBottom = '';

if ($url == 'site/index') {
    $classNavbarShow = 'show';
    $classMarginBottom = 'mb-5';
}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!--<div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <?php
    /*                        if (!is_null($this->title)) {
                                echo \yii\helpers\Html::encode($this->title);
                            } else {
                                echo \yii\helpers\Inflector::camelize($this->context->id);
                            }
                            */ ?>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <?php
    /*                    echo Breadcrumbs::widget([
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                            'options' => [
                                'class' => 'breadcrumb float-sm-right'
                            ]
                        ]);
                        */ ?>
                </div>
            </div>
        </div>
    </div>-->
    <?php
    if ($url == 'site/index'): ?>
        <?= NavbarMain::widget(['url' => $url]) ?>
    <?php else: ?>
        <?= NavbarOther::widget(['url' => $url]) ?>
    <? endif; ?>

    <?= HeaderStart::widget(['url' => $url, 'title' => Yii::$app->getView()->title]) ?>
    <!-- Main content -->
    <div class="content">
        <?= $content ?><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>