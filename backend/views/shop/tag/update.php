<?php

/* @var $this yii\web\View */
/* @var $tag \core\entities\Shop\Product\Tag */
/* @var $model \core\forms\manage\Shop\TagForm*/

$this->title = Yii::t('shop/tag','Update Tag: ') . $tag->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop/tag','Tag'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $tag->name, 'url' => ['view', 'id' => $tag->id]];
$this->params['breadcrumbs'][] = Yii::t('app','Update');
?>
<div class="brand-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>