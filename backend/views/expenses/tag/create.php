<?php


/* @var $this \yii\web\View */

/* @var $model \core\forms\manage\Expenses\TagForm */

$this->title = 'Create Tag';
$this->params['breadcrumbs'][] = ['label' => 'Tags', 'url' => ['index']];
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