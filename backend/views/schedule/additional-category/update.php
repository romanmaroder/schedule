<?php



/* @var $this \yii\web\View */
/* @var $model \core\forms\manage\Schedule\Additional\CategoryForm */
/* @var $category \core\entities\Schedule\Additional\Category */


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