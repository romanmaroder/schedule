<?php



/* @var $this \yii\web\View */
/* @var $review \core\entities\Shop\Product\Review */
/* @var $product \core\entities\Shop\Product\Product */

use hail812\adminlte3\assets\PluginAsset;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

$this->title = $review->vote;
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop/review','Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

YiiAsset::register($this);
PluginAsset::register($this)->add(['sweetalert2']);
?>

<div class="card card-secondary">
    <div class="card-header">

        <?= Html::a(
            Yii::t('app','Update'),
            ['update', 'product_id'=>$product->id,'id' => $review->id],
            ['class' => 'btn btn-primary btn-sm btn-shadow btn-gradient']
        ) ?>
        <?php
        if ($review->isActive()): ?>
            <?= Html::a(
                Yii::t('app','Delete'),
                ['delete', 'product_id' => $product->id,'id' => $review->id],
                [
                    'class' => 'btn btn-danger btn-sm btn-shadow btn-gradient',
                    'data' => [
                        'confirm' => Yii::t('app', 'Delete file?'),
                        'method' => 'post',
                    ],
                ]
            ) ?>
        <?php
        else: ?>
            <?= Html::a(
                Yii::t('app','Restore'),
                ['activate', 'product_id' => $product->id,'id' => $review->id],
                [
                    'class' => 'btn btn-success btn-sm btn-shadow btn-gradient',
                    'data' => [
                        'confirm' => 'Are you sure you want to activate this item?',
                        'method' => 'post',
                    ],
                ]
            ) ?>
        <?php
        endif; ?>
        <div class='card-tools'>
            <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
            </button>
            <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
            </button>
        </div>
    </div>

    <div class="card-body">
        <div class="form-group">
            <?= DetailView::widget(
                [
                    'model' => $review,
                    'attributes' => [
                        'id',
                        'active:boolean',
                        [
                            'attribute' => 'user_id',
                            'value' => function($review){
                                return $review->user->username;
                            }
                        ],
                        [
                            'attribute' => 'product_id',
                            'value' => function($review){
                                return $review->product->name;
                            }
                        ],
                        [
                            'attribute' => 'vote',
                            'value' => $review->vote,
                        ],
                        [
                            'attribute' => 'text',
                            'value' => Yii::$app->formatter->asNtext($review->text),
                            'format' => 'raw',
                        ],
                        [
                                'attribute' => 'created_at',
                            'format' => 'datetime',
                        ]
                    ],
                ]
            ) ?>
        </div>
    </div>
</div>