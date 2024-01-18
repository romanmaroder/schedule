<?php



/* @var $this \yii\web\View */
/* @var $model \schedule\forms\manage\User\Price\PriceForm */
/* @var $price null|\schedule\entities\User\Price */

$this->title = 'Update Price: ' . $price->name;
$this->params['breadcrumbs'][] = ['label' => 'Prices', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $price->name, 'url' => ['view', 'id' => $price->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="price-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>