<?php



/* @var $this \yii\web\View */
/* @var $model \core\forms\manage\PageForm */
/* @var $page \core\entities\Page */


$this->title = 'Update Page: ' . $page->title;
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $page->title, 'url' => ['view', 'id' => $page->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="page-update">

    <?= $this->render(
        '_form',
        [
            'model' => $model,
        ]
    ) ?>

</div>