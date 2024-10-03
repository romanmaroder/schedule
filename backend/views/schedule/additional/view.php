<?php


use hail812\adminlte3\assets\PluginAsset;
use core\helpers\AdditionalHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $additional \core\entities\Schedule\Additional\Additional */

$this->title = $additional->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('schedule/additional','Additional'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

YiiAsset::register($this);
PluginAsset::register($this)->add(['sweetalert2']);
?>
<div class="service-view">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class='card-header'>
                    <h3 class='card-title'>
                        <?php
                        if ($additional->isActive()) : ?>
                            <?= Html::a(
                                Yii::t('app','Draft'),
                                ['draft', 'id' => $additional->id],
                                ['class' => 'btn btn-primary btn-shadow btn-sm btn-gradient btn-shadow', 'data-method' => 'post']
                            ) ?>
                        <?php
                        else : ?>
                            <?= Html::a(
                                Yii::t('app','Activate'),
                                ['activate', 'id' => $additional->id],
                                ['class' => 'btn btn-success btn-shadow btn-sm btn-gradient btn-shadow', 'data-method' => 'post']
                            ) ?>
                        <?php
                        endif; ?>
                        <?= Html::a(Yii::t('app','Update'), ['update', 'id' => $additional->id], ['class' => 'btn btn-primary btn-shadow btn-sm btn-gradient btn-shadow']) ?>
                        <?= Html::a(
                            Yii::t('app','Delete'),
                            ['delete', 'id' => $additional->id],
                            [
                                'class' => 'btn btn-danger btn-shadow btn-sm btn-gradient btn-shadow',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ],
                            ]
                        ) ?>

                    </h3>
                    <div class='card-tools'>
                        <button type='button' class='btn btn-tool' data-card-widget='maximize'><i
                                    class='fas fa-expand'></i>
                        </button>
                        <button type='button' class='btn btn-tool' data-card-widget='collapse'><i
                                    class='fas fa-minus'></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <?= DetailView::widget(
                        [
                            'model' => $additional,
                            'attributes' => [
                                'id',
                                [
                                    'attribute' => 'status',
                                    'value' => AdditionalHelper::statusLabel($additional->status),
                                    'format' => 'raw',
                                ],
                                'name',
                                [
                                    'attribute' => 'category_id',
                                    'value' => ArrayHelper::getValue($additional, 'category.name'),
                                ],
                                [
                                    'attribute' => 'additional.categories',
                                    //'label' => 'Other categories',
                                    'value' => implode(', ', ArrayHelper::getColumn($additional->categories, 'name')),
                                ],
                            ],
                        ]
                    ) ?>
                </div>
            </div>
        </div>

    </div>

    <div class="card card-outline card-secondary">
        <div class='card-header'>
            <h3 class='card-title'><?=Yii::t('schedule/additional','Description')?></h3>
            <div class='card-tools'>
                <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
                </button>
                <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <?= Yii::$app->formatter->asHtml($additional->description, [
                'Attr.AllowedRel' => array('nofollow'),
                'HTML.SafeObject' => true,
                'Output.FlashCompat' => true,
                'HTML.SafeIframe' => true,
                'URI.SafeIframeRegexp'=>'%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
            ]) ?>
        </div>
    </div>

    <div class="card card-outline card-secondary">
        <div class='card-header'>
            <h3 class='card-title'>SEO</h3>
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
                    'model' => $additional,
                    'attributes' => [
                        [
                            'attribute' => 'meta.title',
                            'value' => $additional->meta->title,
                        ],
                        [
                            'attribute' => 'meta.description',
                            'value' => $additional->meta->description,
                        ],
                        [
                            'attribute' => 'meta.keywords',
                            'value' => $additional->meta->keywords,
                        ],
                    ],
                ]
            ) ?>
        </div>
    </div>
</div>