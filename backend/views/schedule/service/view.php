<?php


use hail812\adminlte3\assets\PluginAsset;
use schedule\helpers\PriceHelper;
use schedule\helpers\ServiceHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $service schedule\entities\Schedule\Service\Service */

$this->title = $service->name;
$this->params['breadcrumbs'][] = ['label' => 'Service', 'url' => ['index']];
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
                        if ($service->isActive()) : ?>
                            <?= Html::a(
                                'Draft',
                                ['draft', 'id' => $service->id],
                                ['class' => 'btn btn-primary btn-shadow', 'data-method' => 'post']
                            ) ?>
                        <?php
                        else : ?>
                            <?= Html::a(
                                'Activate',
                                ['activate', 'id' => $service->id],
                                ['class' => 'btn btn-success btn-shadow', 'data-method' => 'post']
                            ) ?>
                        <?php
                        endif; ?>
                        <?= Html::a('Update', ['update', 'id' => $service->id], ['class' => 'btn btn-primary btn-shadow']) ?>
                        <?= Html::a(
                            'Delete',
                            ['delete', 'id' => $service->id],
                            [
                                'class' => 'btn btn-danger btn-shadow',
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
                            'model' => $service,
                            'attributes' => [
                                'id',
                                [
                                    'attribute' => 'status',
                                    'value' => ServiceHelper::statusLabel($service->status),
                                    'format' => 'raw',
                                ],
                                'name',
                                [
                                    'attribute' => 'price_new',
                                    'value' => PriceHelper::format($service->price_new),
                                ],
                                [
                                    'attribute' => 'price_old',
                                    'value' => PriceHelper::format($service->price_old),
                                ],
                                [
                                    'attribute' => 'price_intern',
                                    'value' => PriceHelper::format($service->price_intern),
                                ],
                                [
                                    'attribute' => 'price_employee',
                                    'value' => PriceHelper::format($service->price_employee),
                                ],
                                [
                                    'attribute' => 'category_id',
                                    'value' => ArrayHelper::getValue($service, 'category.name'),
                                ],
                                [
                                    'label' => 'Other categories',
                                    'value' => implode(', ', ArrayHelper::getColumn($service->categories, 'name')),
                                ],
                                [
                                    'label' => 'Tags',
                                    'value' => implode(', ', ArrayHelper::getColumn($service->tags, 'name')),
                                ],
                            ],
                        ]
                    ) ?>
                    <br/>
                    <p>
                        <?= Html::a('Change Price', ['price', 'id' => $service->id], ['class' => 'btn btn-primary']) ?>
                    </p>
                </div>
            </div>
        </div>

    </div>

    <div class="card card-outline card-secondary">
        <div class='card-header'>
            <h3 class='card-title'>Description</h3>
            <div class='card-tools'>
                <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
                </button>
                <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <?= Yii::$app->formatter->asNtext($service->description) ?>
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
                    'model' => $service,
                    'attributes' => [
                        [
                            'attribute' => 'meta.title',
                            'value' => $service->meta->title,
                        ],
                        [
                            'attribute' => 'meta.description',
                            'value' => $service->meta->description,
                        ],
                        [
                            'attribute' => 'meta.keywords',
                            'value' => $service->meta->keywords,
                        ],
                    ],
                ]
            ) ?>
        </div>
    </div>
</div>