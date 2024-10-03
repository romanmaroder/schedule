<?php



/* @var $this \yii\web\View */
/* @var $model \core\forms\manage\Schedule\Additional\CategoryForm */


$this->title = Yii::t('schedule/additional/category','Create Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('schedule/additional/category','Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>