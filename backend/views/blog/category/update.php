<?php

/* @var $this yii\web\View */
/* @var $category core\entities\Blog\Category */
/* @var $model core\forms\manage\Blog\CategoryForm */

$this->title = 'Update Category: ' . $category->name;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => ['view', 'id' => $category->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="category-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>