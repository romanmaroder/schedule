<?php

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\Shop\CategoryForm */

$this->title = Yii::t('shop/category','Create Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop/category','Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>