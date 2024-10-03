<?php

/* @var $this yii\web\View */
/* @var $model core\forms\manage\Schedule\CategoryForm */

$this->title = Yii::t('schedule/service/category','Create Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('schedule/service/category','Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>