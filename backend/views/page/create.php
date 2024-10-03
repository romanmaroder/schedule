<?php



/* @var $this \yii\web\View */
/* @var $model \core\forms\manage\PageForm */


$this->title = Yii::t('content/page','Create Page');
$this->params['breadcrumbs'][] = ['label' => Yii::t('content/page','Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-create">

    <?= $this->render(
        '_form',
        [
            'model' => $model,
        ]
    ) ?>

</div>