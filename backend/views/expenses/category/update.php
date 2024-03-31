<?php



/* @var $this \yii\web\View */
/* @var $model \schedule\forms\manage\Expenses\CategoryForm */
/* @var $category \schedule\entities\Expenses\Category */

$this->title = 'Update Expenses categories: ' . $category->name;
$this->params['breadcrumbs'][] = ['label' => 'Expenses categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => ['view', 'id' => $category->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="category-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>