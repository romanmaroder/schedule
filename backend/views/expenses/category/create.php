<?php



/* @var $this \yii\web\View */
/* @var $model \core\forms\manage\Expenses\CategoryForm */

$this->title = Yii::t('expenses/category','Create Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('expenses/category','Categories expenses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>