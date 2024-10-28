<?php

/** @var \yii\web\View $this */

/** @var string $content */


use hail812\adminlte3\assets\FontAwesomeAsset;
use shop\assets\AppAsset;
use shop\assets\BlogAsset;
use shop\assets\OwlCarouselAsset;
use yii\bootstrap5\Html;

OwlCarouselAsset::register($this);
BlogAsset::register($this);
AppAsset::register($this);
FontAwesomeAsset::register($this);
//$user = \core\entities\User\User::findOne(Yii::$app->user->identity->getId());
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" class="h-100">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <div class="wrapper">
        <!-- Navbar -->
        <?= $this->render('navbar', ['assetDir' =>'' ]) ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?/*= $this->render('sidebar', ['assetDir' => $assetDir]) */?>

        <!-- Content Wrapper. Contains page content -->
        <?= $this->render('content-blog', ['content' => $content, 'url' => Yii::$app->requestedRoute]) ?>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <?/*= $this->render('control-sidebar') */?>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <?= $this->render('footer') ?>
    </div>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage();
