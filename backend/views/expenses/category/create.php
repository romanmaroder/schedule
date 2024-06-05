<?php



/* @var $this \yii\web\View */
/* @var $model \core\forms\manage\Expenses\CategoryForm */

$this->title = 'Create Expenses categories';
$this->params['breadcrumbs'][] = ['label' => 'Expenses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>