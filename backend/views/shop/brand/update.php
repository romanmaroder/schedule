<?php

/* @var $this yii\web\View */
/* @var $brand \core\entities\CommonUses\Brand */
/* @var $model \core\forms\manage\Shop\BrandForm */

$this->title = Yii::t('shop/brand','Update Brand: ') . $brand->name;
$this->params['breadcrumbs'][] = ['label' =>  Yii::t('shop/brand','Brands'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $brand->name, 'url' => ['view', 'id' => $brand->id]];
$this->params['breadcrumbs'][] =  Yii::t('app','Update');
?>
<div class="brand-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>