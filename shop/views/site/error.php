<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
$this->params['breadcrumbs'] = [['label' => $this->title]];

?>

<!-- Main content -->
<section class="container-fluid">
    <div class="error-page">
        <h2 class="headline text-warning"> 404</h2>

        <div class="error-content pl-md-3">
            <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! <?= nl2br(Html::encode($message)) ?>.</h3>

            <p class="text-center">
                We could not find the page you were looking for.
                Meanwhile, you may <?= Html::a('return to Home', Yii::$app->homeUrl); ?> or try using the search form.
            </p>

        </div>
        <!-- /.error-content -->
    </div>
</section>
    <!-- /.error-page -->

