<?php

/* @var $this yii\web\View */
/* @var $model core\forms\manage\Shop\TagForm */

$this->title = Yii::t('shop/tag','Create Tag');
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop/tag','Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>