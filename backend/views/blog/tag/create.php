<?php
/* @var $this yii\web\View */
/* @var $model core\forms\manage\Blog\TagForm */

$this->title = Yii::t('blog/tag','Create Tag');
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog/tag','Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="tag-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>