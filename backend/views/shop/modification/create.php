<?php

/* @var $this yii\web\View */
/* @var $product core\entities\core\Product\Product */
/* @var $model core\forms\manage\core\Product\ModificationForm */

$this->title = 'Create Modification';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['core/product/index']];
$this->params['breadcrumbs'][] = ['label' => $product->name, 'url' => ['core/product/view', 'id' => $product->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modification-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>