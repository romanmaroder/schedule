<?php


/* @var $this \yii\web\View */

/* @var $order \core\entities\Shop\Order\Order|null */

use core\helpers\OrderHelper;
use core\helpers\PriceHelper;
use hail812\adminlte3\assets\PluginAsset;
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Order ' . $order->id;
$this->params['breadcrumbs'][] = ['label' => 'Cabinet', 'url' => ['cabinet/default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

PluginAsset::register($this)->add(
    ['datatables', 'datatables-bs4', 'datatables-responsive', 'datatables-buttons', 'sweetalert2']
);
?>
    <div class="user-view">

        <h1><?= Html::encode($this->title) ?></h1>

        <?= DetailView::widget(
            [
                'model' => $order,
                'attributes' => [
                    'id',
                    'created_at:datetime',
                    [
                        'attribute' => 'current_status',
                        'value' => OrderHelper::statusLabel($order->current_status),
                        'format' => 'raw',
                    ],
                    'delivery_method_name',
                    'deliveryData.index',
                'deliveryData.address',
                'cost',
                'note:ntext',
            ],
        ]
    ) ?>

    <div class="table-responsive">
        <table class="table table-bordered" id="detail">
            <thead>
            <tr>
                <th class="text-left">Product Name</th>
                <th class="text-left">Model</th>
                <th class="text-left">Quantity</th>
                <th class="text-right">Unit Price</th>
                <th class="text-right">Total</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($order->items as $item): ?>
                <tr>
                    <td class="text-left">
                        <?= Html::encode($item->product_name) ?>
                    </td>
                    <td class="text-left">
                        <?= Html::encode($item->modification_code) ?>
                        <?= Html::encode($item->modification_name) ?>
                    </td>
                    <td class="text-left">
                        <?= $item->quantity ?>
                    </td>
                    <td class="text-right"><?= PriceHelper::format($item->price) ?></td>
                    <td class="text-right"><?= PriceHelper::format($item->getCost()) ?></td>
                </tr>
            <?php
            endforeach; ?>
            </tbody>
        </table>
    </div>

        <?php
        if ($order->canBePaid()): ?>
            <p class="mt-2">
                <?= Html::a(
                    'Pay via Robokassa',
                    ['/payment/robokassa/invoice', 'id' => $order->id],
                    ['class' => 'btn btn-sm btn-gradient shadow btn-success rounded']
                ) ?>
            </p>
        <?php
        endif; ?>

    </div>

<?php

$js = <<< JS
 $(function () {
    $('#detail').DataTable({
    
       "paging": false,
       "lengthChange": false,
       "searching": false,
       "ordering": true,
       //"order": [[0, 'desc']],
       "info": false,
       "autoWidth": false,
       "responsive": true,
        // "dom": "<'row'<'col-6 col-md-6 order-3 order-md-1 text-left'B><'col-sm-12 order-md-2 col-md-6 d-flex d-md-block'f>>tp",
      // "buttons": [
      //   {
		// 		"text": "Добавить категорию",
		// 		"className":"btn btn-success",
		// 		"tag":"a",
		// 		"attr":{
		// 		//"href":create
		// 		},
		// 		/*"action": function ( e, dt, node, config ) {
		// 		  $(location).attr('href',config.attr.href);
		// 		}*/
      //   }
      //   ],
        "language": {
          "search":"Поиск"
         }
    }).buttons().container().appendTo('#detail_wrapper .col-md-6:eq(0)');

  });

JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

?>