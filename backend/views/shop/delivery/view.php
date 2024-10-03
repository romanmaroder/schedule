<?php

use core\entities\Shop\DeliveryMethod;
use core\helpers\WeightHelper;
use hail812\adminlte3\assets\PluginAsset;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this \yii\web\View */

/* @var $method DeliveryMethod */



$this->title = $method->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop/delivery','Delivery Methods'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

YiiAsset::register($this);
PluginAsset::register($this)->add(['sweetalert2']);
?>
<div class="user-view">

    <div class="card card-secondary">
        <div class="card-header">
            <?= Html::a(Yii::t('app','Update'), ['update', 'id' => $method->id], ['class' => 'btn btn-primary btn-sm btn-shadow btn-gradient']) ?>
            <?= Html::a(
                Yii::t('app','Delete'),
                ['delete', 'id' => $method->id],
                [
                    'class' => 'btn btn-danger btn-sm btn-shadow btn-gradient',
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
                    'model' => $method,
                    'attributes' => [
                        'id',
                        'name',
                        'cost',
                        [
                                'attribute' => 'min_weight',
                            'value' => WeightHelper::format($method->min_weight),
                        ],
                        [
                            'attribute' => 'max_weight',
                            'value' => WeightHelper::format($method->max_weight),
                        ],
                    ],
                ]
            ) ?>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <!-- Footer-->
        </div>
        <!-- /.card-footer-->
    </div>

</div>