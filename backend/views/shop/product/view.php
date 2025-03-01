<?php


use core\entities\Shop\Product\Modification;
use core\entities\Shop\Product\Value;
use core\helpers\PriceHelper;
use core\helpers\StatusHelper;
use core\helpers\WeightHelper;
use hail812\adminlte3\assets\PluginAsset;
use kartik\file\FileInput;
use yii\bootstrap4\ActiveForm;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $product \core\entities\Shop\Product\Product */
/* @var $photosForm \core\forms\manage\Shop\Product\PhotosForm */
/* @var $modificationsProvider yii\data\ActiveDataProvider */

$this->title = $product->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop/product', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

YiiAsset::register($this);
PluginAsset::register($this)->add(['sweetalert2']);

?>
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-secondary">
                        <div class='card-header'>
                            <h3 class='card-title'>
                                <?php
                                if ($product->isActive()) : ?>
                                    <?= Html::a(
                                        Yii::t('app', 'Draft'),
                                        ['draft', 'id' => $product->id],
                                        [
                                            'class' => 'btn btn-primary btn-shadow btn-sm btn-gradient',
                                            'data-method' => 'post'
                                        ]
                                    ) ?>
                                <?php
                                else : ?>
                                    <?= Html::a(
                                        Yii::t('app', 'Activate'),
                                        ['activate', 'id' => $product->id],
                                        [
                                            'class' => 'btn btn-success btn-shadow btn-sm btn-gradient',
                                            'data-method' => 'post'
                                        ]
                                    ) ?>
                                <?php
                                endif; ?>
                                <?= Html::a(
                                    Yii::t('app', 'Update'),
                                    ['update', 'id' => $product->id],
                                    ['class' => 'btn btn-primary btn-shadow btn-sm btn-gradient']
                                ) ?>
                                <?= Html::a(
                                    Yii::t('app', 'Delete'),
                                    ['delete', 'id' => $product->id],
                                    [
                                        'class' => 'btn btn-danger btn-shadow btn-sm btn-gradient',
                                        'data' => [
                                            'confirm' => Yii::t('app', 'Delete file?'),
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
                                    'model' => $product,
                                    'attributes' => [
                                        'id',
                                        [
                                            'attribute' => 'status',
                                            'value' => StatusHelper::statusLabel($product->status),
                                            'format' => 'raw',
                                        ],
                                        [
                                            'attribute' => 'brand_id',
                                            'value' => ArrayHelper::getValue($product, 'brand.name'),
                                        ],
                                        'code',
                                        'name',
                                        'quantity',
                                        [
                                            'attribute' => 'weight',
                                            'value' => WeightHelper::format($product->weight),
                                        ],
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
                                            'attribute' => 'others_category',
                                            'value' => implode(
                                                ', ',
                                                ArrayHelper::getColumn($product->categories, 'name')
                                            ),
                                        ],
                                        [
                                            'attribute' => 'tags',
                                            'value' => implode(', ', ArrayHelper::getColumn($product->tags, 'name')),
                                        ],
                                    ],
                                ]
                            ) ?>
                            <br/>
                            <p>
                                <?= Html::a(
                                    Yii::t('shop/product', 'Change Price'),
                                    ['price', 'id' => $product->id],
                                    ['class' => 'btn btn-primary btn-sm btn-gradient btn-shadow']
                                ) ?>
                                <?php
                                if ($product->canChangeQuantity()): ?>
                                    <?= Html::a(
                                        Yii::t('shop/product', 'Change Quantity'),
                                        ['quantity', 'id' => $product->id],
                                        ['class' => 'btn btn-sm btn-gradient btn-shadow btn-primary']
                                    ) ?>
                                <?php
                                endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-secondary">
                        <div class='card-header'>
                            <h3 class='card-title'><?= Yii::t('shop/characteristic', 'Characteristic') ?></h3>
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
                                        fn(Value $value) => [
                                            'label' => $value->characteristic->name,
                                            'value' => $value->value,
                                        ],
                                        $product->values
                                    ),
                                ]
                            ) ?>
                        </div>
                    </div>
                    <div class="card card-secondary">
                        <div class='card-header'>
                            <h3 class='card-title'><?= Yii::t('shop/product', 'description') ?></h3>
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
                            <?= Yii::$app->formatter->asHtml($product->description, [
                                'Attr.AllowedRel' => array('nofollow'),
                                'HTML.SafeObject' => true,
                                'Output.FlashCompat' => true,
                                'HTML.SafeIframe' => true,
                                'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                            ]) ?>
                        </div>
                    </div>
                    <div class="card card-secondary">
                        <div class='card-header'>
                            <h3 class='card-title'>SEO</h3>
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
                </div>
            </div>
            <div class="card card-secondary" id="modifications">
                <div class='card-header'>
                    <h3 class='card-title'><?= Yii::t('shop/product', 'modifications') ?></h3>
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
                    <p>
                        <?= Html::a(
                            Yii::t('app', 'Add'),
                            ['shop/modification/create', 'product_id' => $product->id],
                            ['class' => 'btn btn-success btn-gradient btn-sm btn-gradient btn-shadow']
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
                                    'value' => fn (Modification $model) =>
                                         PriceHelper::format($model->price),
                                ],
                                'quantity',
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
            <div class="card card-secondary" id="photos">
                <div class='card-header'>
                    <h3 class='card-title'><?= Yii::t('shop/product', 'photos') ?></h3>
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
                            <?= Html::submitButton(
                                Yii::t('app', 'Upload'),
                                ['class' => 'btn btn-success btn-sm btn-gradient btn-shadow']
                            ) ?>
                        </div>

                        <?php
                        ActiveForm::end(); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>