<?php



/* @var $this \yii\web\View */
/* @var $page null|\schedule\entities\Page */

use yii\helpers\Html;

$this->title = $page->getSeoTitle();

$this->registerMetaTag(['name' => 'description', 'content' => $page->meta->description]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $page->meta->keywords]);

foreach ($page->parents as $parent) {
    if (!$parent->isRoot()) {
        $this->params['breadcrumbs'][] = ['label' => $parent->title, 'url' => ['view', 'id' => $parent->id]];
    }
}
$this->params['breadcrumbs'][] = $page->title;
?>

<div class="site-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 single-content">
                <h1 class="mb-4">
                    <?= Html::encode($page->title) ?>
                </h1>
                <p class="text-secondary"> <?= Yii::$app->formatter->asNtext($page->content) ?></p>
            </div>
        </div>
    </div>
</div>
