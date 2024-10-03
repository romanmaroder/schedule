<?php

/* @var $this yii\web\View */
/* @var $category core\entities\Schedule\Service\Category */
/* @var $model core\forms\manage\Schedule\CategoryForm */

$this->title = Yii::t('schedule/service/category','Update Category: ') . $category->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('schedule/service/category','Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => ['view', 'id' => $category->id]];
$this->params['breadcrumbs'][] = Yii::t('app','Update');
?>
<div class="category-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>