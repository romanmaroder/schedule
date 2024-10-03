<?php

/* @var $this yii\web\View */
/* @var $tag core\entities\Blog\Tag */
/* @var $model core\forms\manage\Blog\TagForm */

$this->title = Yii::t('blog/tag','Update Tag: ') . $tag->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog/tag','Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $tag->name, 'url' => ['view', 'id' => $tag->id]];
$this->params['breadcrumbs'][] = Yii::t('app','Update');
?>
<div class="tag-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>