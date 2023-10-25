<?php


use kartik\file\FileInput;
use schedule\entities\Schedule\Product\Modification;
use schedule\entities\Schedule\Product\Value;
use yii\bootstrap4\ActiveForm;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $product schedule\entities\Schedule\Product\Product */
/* @var $photosForm schedule\forms\manage\Schedule\Product\PhotosForm */
/* @var $modificationsProvider yii\data\ActiveDataProvider */

$this->title = $product->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <p>
        <?php
        if ($product->isActive()) : ?>
            <?= Html::a(
                'Draft',
                ['draft', 'id' => $product->id],
                ['class' => 'btn btn-primary', 'data-method' => 'post']
            ) ?>
        <?php
        else : ?>
            <?= Html::a(
                'Activate',
                ['activate', 'id' => $product->id],
                ['class' => 'btn btn-success', 'data-method' => 'post']
            ) ?>
        <?php
        endif; ?>
        <?= Html::a('Update', ['update', 'id' => $product->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(
            'Delete',
            ['delete', 'id' => $product->id],
            [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]
        ) ?>
    </p>

    <div class="row">
        <div class="col-md-6">
            <div class="card card-outline card-secondary">
                <div class='card-header'>
                    <h3 class='card-title'>Common</h3>
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
                            'model' => $product,
                            'attributes' => [
                                'id',
                                [
                                    'attribute' => 'status',
                                    'value' => ProductHelper::statusLabel($product->status),
                                    'format' => 'raw',
                                ],
                                [
                                    'attribute' => 'brand_id',
                                    'value' => ArrayHelper::getValue($product, 'brand.name'),
                                ],
                                'code',
                                'name',
                                [
                                    'attribute' => 'price_new',
                                    'value' => PriceHelper::format($product->price_new),
                                ],
                                [
                                    'attribute' => 'price_old',
                                    'value' => PriceHelper::format($product->price_old),
                                ],
                                [
                                    'attribute' => 'category_id',
                                    'value' => ArrayHelper::getValue($product, 'category.name'),
                                ],
                                [
                                    'label' => 'Other categories',
                                    'value' => implode(', ', ArrayHelper::getColumn($product->categories, 'name')),
                                ],
                                [
                                    'label' => 'Tags',
                                    'value' => implode(', ', ArrayHelper::getColumn($product->tags, 'name')),
                                ],
                            ],
                        ]
                    ) ?>
                    <br/>
                    <p>
                        <?= Html::a('Change Price', ['price', 'id' => $product->id], ['class' => 'btn btn-primary']) ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">

            <div class="card card-outline card-secondary">
                <div class='card-header'>
                    <h3 class='card-title'>Characteristics</h3>
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
                            'model' => $product,
                            'attributes' => array_map(
                                function (Value $value) {
                                    return [
                                        'label' => $value->characteristic->name,
                                        'value' => $value->value,
                                    ];
                                },
                                $product->values
                            ),
                        ]
                    ) ?>
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
            <?= Yii::$app->formatter->asNtext($product->description) ?>
        </div>
    </div>

    <div class="card card-outline card-secondary" id="modifications">
        <div class='card-header'>
            <h3 class='card-title'>Modifications</h3>
            <div class='card-tools'>
                <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
                </button>
                <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <p>
                <?= Html::a(
                    'Add Modification',
                    ['shop/modification/create', 'product_id' => $product->id],
                    ['class' => 'btn btn-success']
                ) ?>
            </p>
            <?= GridView::widget(
                [
                    'dataProvider' => $modificationsProvider,
                    'columns' => [
                        'code',
                        'name',
                        [
                            'attribute' => 'price',
                            'value' => function (Modification $model) {
                                return PriceHelper::format($model->price);
                            },
                        ],
                        [
                            'class' => ActionColumn::class,
                            'controller' => 'shop/modification',
                            'template' => '{update} {delete}',
                        ],
                    ],
                ]
            ); ?>
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
                    'model' => $product,
                    'attributes' => [
                        [
                            'attribute' => 'meta.title',
                            'value' => $product->meta->title,
                        ],
                        [
                            'attribute' => 'meta.description',
                            'value' => $product->meta->description,
                        ],
                        [
                            'attribute' => 'meta.keywords',
                            'value' => $product->meta->keywords,
                        ],
                    ],
                ]
            ) ?>
        </div>
    </div>

    <div class="card card-outline card-secondary" id="photos">
        <div class='card-header'>
            <h3 class='card-title'>Photos</h3>
            <div class='card-tools'>
                <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
                </button>
                <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
                </button>
            </div>
        </div>
        <div class="card-body">

            <div class="row align-items-center">
                <?php
                foreach ($product->photos as $photo): ?>
                    <div class="col-md-2 col-xl-3" style="text-align: center">
                        <div class="photo-block d-flex align-items-center">
                            <div class="btn-group-vertical btn-group-sm pr-2 ">

                                <?= Html::a(
                                    '<i class="fas fa-arrow-up d-md-none"></i>
                                <i class="fas fa-arrow-left d-none d-md-flex"></i>',
                                    ['move-photo-up', 'id' => $product->id, 'photo_id' => $photo->id],
                                    [
                                        'class' => 'btn btn-default',
                                        'data-method' => 'post',
                                    ]
                                ); ?>
                                <?= Html::a(
                                    '<i class="fas fa-times"></i>',
                                    ['delete-photo', 'id' => $product->id, 'photo_id' => $photo->id],
                                    [
                                        'class' => 'btn btn-default',
                                        'data-method' => 'post',
                                        'data-confirm' => 'Remove photo?',
                                    ]
                                ); ?>
                                <?= Html::a(
                                    '<i class="fas fa-arrow-down d-md-none"></i><i
                                        class="fas fa-arrow-right d-none d-md-flex"></i>',
                                    ['move-photo-down', 'id' => $product->id, 'photo_id' => $photo->id],
                                    [
                                        'class' => 'btn btn-default',
                                        'data-method' => 'post',
                                    ]
                                ); ?>
                            </div>
                            <div class="photo-thumb">
                                <?= Html::a(
                                    Html::img($photo->getThumbFileUrl('file', 'thumb')),
                                    $photo->getUploadedFileUrl('file'),
                                    ['class' => 'thumbnail', 'target' => '_blank']
                                ) ?>
                            </div>
                        </div>
                    </div>
                <?php
                endforeach; ?>
            </div>
            <div class="row">
                <div class="col-12 my-3">

                    <?php
                    $form = ActiveForm::begin(
                        [
                            'options' => ['enctype' => 'multipart/form-data'],
                        ]
                    ); ?>

                    <?= $form->field($photosForm, 'files[]')->label(false)->widget(
                        FileInput::class,
                        [
                            'options' => [
                                'accept' => 'image/*',
                                'multiple' => true,
                            ]
                        ]
                    ) ?>

                </div>
            </div>

            <div class='card-footer bg-secondary'>
                <div class='form-group'>
                    <?= Html::submitButton('Upload', ['class' => 'btn btn-success']) ?>
                </div>

                <?php
                ActiveForm::end(); ?>
            </div>
        </div>

    </div>