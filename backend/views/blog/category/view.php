<?php

use hail812\adminlte3\assets\PluginAsset;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $category core\entities\Blog\Category */

$this->title = $category->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog/category','Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

YiiAsset::register($this);
PluginAsset::register($this)->add(['sweetalert2']);
?>
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col">
            <div class="card card-secondary">
                <div class="card-header">
                    <?= Html::a(
                        Yii::t('app','Update'),
                        ['update', 'id' => $category->id],
                        ['class' => 'btn btn-primary btn-sm btn-shadow bg-gradient text-shadow']
                    ) ?>
                    <?= Html::a(
                        Yii::t('app','Delete'),
                        ['delete', 'id' => $category->id],
                        [
                            'class' => 'btn btn-danger btn-sm btn-shadow bg-gradient text-shadow',
                            'data' => [
                                'confirm' => Yii::t('app', 'Delete file?'),
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
                            'model' => $category,
                            'attributes' => [
                                'id',
                                'name',
                                'slug',
                                'title',
                                'sort',
                            ],
                        ]
                    ) ?>
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
                            'model' => $category,
                            'attributes' => [
                                'meta.title',
                                'meta.description',
                                'meta.keywords',
                            ],
                        ]
                    ) ?>
                </div>
</div>

            <div class="card card-secondary">
                <div class="card-header">
                    <?= Yii::t('blog/category','Description')?>
                    <div class='card-tools'>
                        <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
                        </button>
                        <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <?= Yii::$app->formatter->asHtml($category->description, [
                        'Attr.AllowedRel' => array('nofollow'),
                        'HTML.SafeObject' => true,
                        'Output.FlashCompat' => true,
                        'HTML.SafeIframe' => true,
                        'URI.SafeIframeRegexp'=>'%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>