<?php

/* @var $this yii\web\View */
/* @var $product schedule\entities\Schedule\Product\Product */
/* @var $modification schedule\entities\Schedule\Product\Modification */
/* @var $model schedule\forms\manage\Schedule\Product\ModificationForm */

$this->title = 'Update Modification: ' . $modification->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['schedule/product/index']];
$this->params['breadcrumbs'][] = ['label' => $product->name, 'url' => ['schedule/product/view', 'id' => $product->id]];
$this->params['breadcrumbs'][] = $modification->name;
?>
<div class="modification-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>