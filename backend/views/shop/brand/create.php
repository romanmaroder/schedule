<?php

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\Shop\BrandForm */

$this->title = Yii::t('shop/brand','Create Brand');
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop/brand','Brands'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>