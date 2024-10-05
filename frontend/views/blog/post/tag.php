<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\DataProviderInterface */
/* @var $tag \core\entities\Blog\Tag */

use yii\helpers\Html;

$this->title = Yii::t('blog','Posts with tag ') . ' "'. $tag->name . '"';

$this->params['breadcrumbs'][] = ['label' => Yii::t('blog','Blog'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $tag->name;

foreach ($dataProvider->getModels() as $model) {
    $this->params['active_category'] = $model->category;
}

?>

<!--<h1>Posts with tag &laquo;<?/*= Html::encode($tag->name) */?>&raquo;</h1>-->

<?= $this->render('_list', [
    'dataProvider' => $dataProvider
]) ?>
