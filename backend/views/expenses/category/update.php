<?php



/* @var $this \yii\web\View */
/* @var $model \core\forms\manage\Expenses\CategoryForm */
/* @var $category \core\entities\Expenses\Category */

$this->title = Yii::t('expenses/category','Update Category: ') . $category->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('expenses/category','Categories expenses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => ['view', 'id' => $category->id]];
$this->params['breadcrumbs'][] = Yii::t('app','Update');
?>
<div class="category-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>