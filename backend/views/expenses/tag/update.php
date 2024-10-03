<?php



/* @var $this \yii\web\View */
/* @var $model \core\forms\manage\Expenses\TagForm */
/* @var $tag \core\entities\Expenses\Expenses\Tag */

$this->title = Yii::t('expenses/tag','Update Tag: ') . $tag->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('expenses/tag','Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $tag->name, 'url' => ['view', 'id' => $tag->id]];
$this->params['breadcrumbs'][] = Yii::t('app','Update');
?>
<div class="tag-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>