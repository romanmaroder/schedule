<?php



/* @var $this \yii\web\View */
/* @var $title  */
/* @var $url */

use yii\helpers\Url;

?>
<?php if ($url !== 'site/index'):?>

<!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3"><?=$title?></h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href=<?= Url::home()?>>Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0"><?=$title?></p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->
<?php endif;?>