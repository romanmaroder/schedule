<?php


/* @var $this \yii\web\View */

/* @var $model \core\forms\manage\Expenses\TagForm */

$this->title = Yii::t('expenses/tag','Create Tag');
$this->params['breadcrumbs'][] = ['label' => Yii::t('expenses/tag','Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="tag-create">

    <?= $this->render(
        '_form',
        [
            'model' => $model,
        ]
    ) ?>

</div>