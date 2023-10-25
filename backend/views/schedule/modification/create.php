<?php

/* @var $this yii\web\View */
/* @var $product schedule\entities\Schedule\Product\Product */
/* @var $model schedule\forms\manage\Schedule\Product\ModificationForm */

$this->title = 'Create Modification';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['schedule/product/index']];
$this->params['breadcrumbs'][] = ['label' => $product->name, 'url' => ['schedule/product/view', 'id' => $product->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modification-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>