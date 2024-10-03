<?php

/* @var $this yii\web\View */
/* @var $tag \core\entities\Schedule\Service\Tag */
/* @var $model core\forms\manage\Schedule\TagForm */

$this->title = Yii::t('schedule/service/tag','Update Tag: ') . $tag->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('schedule/service/tag','Tag'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $tag->name, 'url' => ['view', 'id' => $tag->id]];
$this->params['breadcrumbs'][] = Yii::t('app','Update');
?>
<div class="brand-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>