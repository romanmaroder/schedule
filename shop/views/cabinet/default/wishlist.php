<?php


/* @var $this \yii\web\View */

/* @var $dataProvider \yii\data\ActiveDataProvider */

use core\entities\Shop\Product\Product;
use core\helpers\PriceHelper;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Wish List';
$this->params['breadcrumbs'][] = ['label' => 'Cabinet', 'url' => ['cabinet/default/index']];
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="active tab-pane" id="wishlist">
    <?= GridView::widget(
        [
            'dataProvider' => $dataProvider,
            'summary' => false,
            'headerRowOptions'=>[
                'class' => 'text-center align-middle',
            ],
            'rowOptions' => [
                'class' => 'text-center align-middle',
            ],
            'columns' => [
                [
                    'value' => function (Product $model) {
                        return $model->mainPhoto ? Html::img(
                            $model->mainPhoto->getThumbFileUrl('file', 'cart_list'),
                            ['class' => 'img-shadow']
                        ) : null;
                    },
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'width: 100px'],
                ],
                //'id',
                [
                    'attribute' => 'name',
                    'value' => function (Product $model) {
                        return Html::a(Html::encode($model->name), ['/shop/catalog/product', 'id' => $model->id]);
                    },
                    'contentOptions' => [
                        'class'=>'align-middle'
                    ],
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'price_new',
                    'value' => function (Product $model) {
                        return PriceHelper::format($model->price_new);
                    },
                    'contentOptions' => [
                        'class'=>'align-middle'
                    ],
                ],
                [
                    'class' => ActionColumn::class,
                    'template' => '{delete}',
                    'contentOptions' => [
                            'class'=>'align-middle'
                    ],
                    'buttons' => [
                        'delete' => function ($url, $model, $key) {
                            return Html::a(
                                '<i class="fas fa-trash-alt"></i>',
                                ['cabinet/default/wishlist-delete', 'id' => $model->id],
                                [
                                    'title' => Yii::t('yii', 'Delete'),
                                    'data-confirm' => 'Are you sure you want to delete?',
                                    'data-method' => 'post',
                                ]
                            );
                        },
                    ],
                ],
            ],
        ]
    ); ?>

</div>