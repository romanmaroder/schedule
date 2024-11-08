<?php



/* @var $this \yii\web\View */
/* @var $order \core\entities\Shop\Order\Order */

use core\helpers\OrderHelper;
use core\helpers\PriceHelper;
use hail812\adminlte3\assets\PluginAsset;
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = Yii::t('shop/order','Order ') . $order->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop/order','Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

PluginAsset::register($this)->add(
    ['datatables', 'datatables-bs4', 'datatables-responsive', 'datatables-buttons','sweetalert2']
);
?>
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col">
            <div class="card card-secondary">
                <div class="card-header">
                    <?= Html::a(Yii::t('app','Update'), ['update', 'id' => $order->id], ['class' => 'btn btn-primary btn-sm btn-shadow btn-gradient']) ?>
            <?= Html::a(
                Yii::t('app','Delete'),
                ['delete', 'id' => $order->id],
                [
                    'class' => 'btn btn-danger btn-sm btn-shadow btn-gradient',
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
            <?= DetailView::widget([
                                       'model' => $order,
                                       'attributes' => [
                                           'id',
                                           [
                                               'attribute' => 'created_at',
                                               'format' => 'datetime',
                                           ],
                                           [
                                               'attribute' => 'current_status',
                                               'value' => OrderHelper::statusLabel($order->current_status),
                                               'format' => 'raw',
                                           ],
                                           [
                                               'attribute' => 'user_id',
                                               'value' => function ($order) {
                                                   return $order->customer_name;
                                               },
                                           ],
                                           [
                                               'attribute' => 'delivery_method_name',
                                           ],
                                           [
                                               'attribute' => 'deliveryData.index',
                                           ],
                                           [
                                               'attribute' => 'deliveryData.address',
                                           ],
                                           [
                                               'attribute' => 'cost',
                                           ],
                                           [
                                               'attribute' => 'delivery_cost',
                                           ],
                                           [
                                               'attribute' => 'total_cost',
                                               'value' => function ($order) {
                                                   return $order->getTotalCost();
                                               },
                                           ],
                                           'note:ntext',
                                       ],
                                   ]) ?>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <!-- Footer-->
        </div>
        <!-- /.card-footer-->
    </div>
            <div class="card card-secondary">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" style="margin-bottom: 0">
                            <thead>
                            <tr>
                                <th class="text-left"><?=Yii::t('shop','Product Name')?></th>
                                <th class="text-left"><?=Yii::t('shop','Model')?></th>
                                <th class="text-left"><?=Yii::t('shop','Quantity')?></th>
                                <th class="text-right"><?=Yii::t('shop','Unit Price')?></th>
                                <th class="text-right"><?=Yii::t('shop','Total')?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($order->items as $item): ?>
                                <tr>
                                    <td class="text-left">
                                        <?= Html::encode($item->product_code) ?><br />
                                    </td>
                                    <td class="text-left">
                                        <?= Html::encode($item->modification_code) ?><br />
                                        <?= Html::encode($item->modification_name) ?>
                                    </td>
                                    <td class="text-left">
                                        <?= $item->quantity ?>
                                    </td>
                                    <td class="text-right"><?= PriceHelper::format($item->price) ?></td>
                                    <td class="text-right"><?= PriceHelper::format($item->getCost()) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card card-secondary">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" style="margin-bottom: 0">
                            <thead>
                            <tr>
                                <th class="text-left"><?=Yii::t('shop','Date')?></th>
                                <th class="text-left"><?=Yii::t('shop','Status')?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($order->statuses as $status): ?>
                                <tr>
                                    <td class="text-left">
                                        <?= Yii::$app->formatter->asDatetime($status->created_at) ?>
                                    </td>
                                    <td class="text-left">
                                        <?= OrderHelper::statusLabel($status->value) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>