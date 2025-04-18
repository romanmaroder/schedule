<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\DataProviderInterface */
/* @var $category core\entities\Blog\Category */

$this->title = $category->getSeoTitle();

$this->registerMetaTag(['name' =>'description', 'content' => $category->meta->description]);
$this->registerMetaTag(['name' =>'keywords', 'content' => $category->meta->keywords]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('blog','Blog'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $category->name;

$this->params['active_category'] = $category;
?>

<!--<h1><?/*= Html::encode($category->getHeadingTile()) */?></h1>-->

<?php //if (trim($category->description)): ?>
<?php if ($category->description): ?>

    <blockquote class="blockquote blockquote-shadow mb-5 text-center text-secondary">
        <?= Yii::$app->formatter->asHtml($category->description, [
                'Attr.AllowedRel' => array('nofollow'),
                'HTML.SafeObject' => true,
                'Output.FlashCompat' => true,
                'HTML.SafeIframe' => true,
                'URI.SafeIframeRegexp'=>'%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
            ]) ?>
    </blockquote>
<?php endif; ?>

<?= $this->render('_list', [
    'dataProvider' => $dataProvider
]) ?>
