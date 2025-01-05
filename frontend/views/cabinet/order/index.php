<?php


/* @var $this \yii\web\View */

/* @var $dataProvider \yii\data\ActiveDataProvider */

use core\entities\Shop\Order\Order;
use core\helpers\OrderHelper;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Orders';
$this->params['breadcrumbs'][] = ['label' => 'Cabinet', 'url' => ['cabinet/default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="card ">
        <div class="card-header">
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="maximize" title="Maximize">
                    <i class="fas fa-expand"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <?= GridView::widget(
                [
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'attribute' => 'id',
                            'value' => fn (Order $model) =>
                                 Html::a(Html::encode($model->id), ['view', 'id' => $model->id]),
                            'format' => 'raw',
                        ],
                        'created_at:datetime',
                        [
                            'attribute' => 'status',
                            'value' => fn (Order $model) =>
                                 OrderHelper::statusLabel($model->current_status),
                            'format' => 'raw',
                        ],
                        ['class' => ActionColumn::class,
                            'template' => '{view} {delete}'],
                    ],
                ]
            ); ?>
        </div>
    </div>

