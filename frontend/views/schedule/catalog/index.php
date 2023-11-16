<?php

/* @var $this yii\web\View */
/* @var $category schedule\entities\Schedule\Category */
/* @var $dataProvider yii\data\DataProviderInterface */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Catalog';
$this->params['breadcrumbs'][] = $this->title;
?>

<!--<div class="panel panel-default">
    <div class="panel-body">
        <?php /*foreach ($category->children as $child): */?>
            <a href="<?/*= Html::encode(Url::to(['category', 'id' => $child->id])) */?>"><?/*= Html::encode($child->name) */?></a> &nbsp;
        <?php /*endforeach; */?>
    </div>
</div>-->
<!--<div class="row">-->

        <?= $this->render('_service', [
            'dataProvider' => $dataProvider
        ]) ?>
