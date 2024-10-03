<?php

/* @var $this yii\web\View */
/* @var $model core\forms\manage\Blog\Post\PostForm */

$this->title = Yii::t('blog','Create Post');
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog','Post'),'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="post-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>