<?php

/* @var $this yii\web\View */
/* @var $tag schedule\entities\Schedule\Tag */
/* @var $model schedule\forms\manage\Schedule\TagForm */

$this->title = 'Update Tag: ' . $tag->name;
$this->params['breadcrumbs'][] = ['label' => 'Tag', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $tag->name, 'url' => ['view', 'id' => $tag->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="brand-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>