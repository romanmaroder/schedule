<?php



/* @var $this \yii\web\View */
/* @var $service \schedule\entities\Schedule\Service\Service */
/* @var $category \schedule\entities\Schedule\Category */

use yii\helpers\Url;

$url = Url::to(['service', 'id' => $service->id]);
?>

<div class="col-12 col-md-12 col-lg-8 order-1 order-md-1">
    <div class="row">
        <div class="col-12">
            <div class="post">
                <!-- /.user-block -->
                <h4>Service description</h4>
                <p><?=$service->description ?></p>
                <hr>
                <h4>Category description</h4>
                <p><?=$category->description ?></p>
            </div>
        </div>
    </div>
</div>