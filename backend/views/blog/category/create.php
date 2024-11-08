<?php

/* @var $this yii\web\View */
/* @var $model core\forms\manage\Blog\CategoryForm */

$this->title = Yii::t('blog/category','Create Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog/category','Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>