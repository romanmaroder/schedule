<?php


/* @var $this \yii\web\View */

/* @var $page \core\entities\Page */


use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $page->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('content/page','Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <div class="row mb-2">
        <div class="col">
            <div class="card card-secondary">
                <div class="card-header">
                    <?= Html::a(Yii::t('app','Update'), ['update', 'id' => $page->id], ['class' => 'btn btn-primary btn-sm btn-gradient btn-shadow']) ?>
        <?= Html::a(
            Yii::t('app','Delete'),
            ['delete', 'id' => $page->id],
            [
                'class' => 'btn btn-danger btn-sm btn-gradient btn-shadow',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]
        ) ?>
        <div class='card-tools'>
            <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
            </button>
            <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <?= DetailView::widget(
            [
                'model' => $page,
                'attributes' => [
                    'id',
                    'title',
                    'slug',
                ],
            ]
        ) ?>
    </div>
</div>

<div class="card card-secondary">
    <div class="card-header">
        <?=Yii::t('content/page','content')?>
        <div class='card-tools'>
            <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
            </button>
            <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <?= Yii::$app->formatter->asHtml($page->content, [
            'Attr.AllowedRel' => array('nofollow'),
            'HTML.SafeObject' => true,
            'Output.FlashCompat' => true,
            'HTML.SafeIframe' => true,
            'URI.SafeIframeRegexp'=>'%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
        ]) ?>
    </div>
</div>

<div class="card card-secondary">
    <div class="card-header">
        SEO
        <div class='card-tools'>
            <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
            </button>
            <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <?= DetailView::widget(
            [
                'model' => $page,
                'attributes' => [
                    'meta.title',
                    'meta.description',
                    'meta.keywords',
                ],
            ]
        ) ?>
    </div>
</div>
        </div>
    </div>
</div>