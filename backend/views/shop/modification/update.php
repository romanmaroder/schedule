<?php

/* @var $this yii\web\View */
/* @var $product core\entities\core\Product\Product */
/* @var $modification core\entities\core\Product\Modification */
/* @var $model core\forms\manage\core\Product\ModificationForm */

$this->title = 'Update Modification: ' . $modification->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['core/product/index']];
$this->params['breadcrumbs'][] = ['label' => $product->name, 'url' => ['core/product/view', 'id' => $product->id]];
$this->params['breadcrumbs'][] = $modification->name;
?>
<div class="modification-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>