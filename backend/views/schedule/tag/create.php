<?php

/* @var $this yii\web\View */
/* @var $model core\forms\manage\Schedule\TagForm */

$this->title = Yii::t('schedule/service/tag','Create Tag');
$this->params['breadcrumbs'][] = ['label' =>  Yii::t('schedule/service/tag','Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>