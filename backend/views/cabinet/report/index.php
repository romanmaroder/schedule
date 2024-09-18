<?php

/* @var $this yii\web\View */

/* @var $cart \core\cart\schedule\Cart */

/* @var $model \core\cart\schedule\CartItem */

/* @var $dataProvider \yii\data\ArrayDataProvider */

use core\helpers\DiscountHelper;
use core\helpers\EventPaymentStatusHelper;
use hail812\adminlte3\assets\PluginAsset;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Salary';
$this->params['breadcrumbs'][] = ['label' => 'Cabinet', 'url' => ['/cabinet/default/index']];
$this->params['breadcrumbs'][] = $this->title;

PluginAsset::register($this)->add(
    [
        'datatables',
        'datatables-bs4',
        'datatables-responsive',
        'datatables-buttons',
        'datatables-colreorder',
        'datatables-searchbuilder',
        'datatables-fixedheader',
    ]
);


?>
    <div class="salary-index">

        <div class="table-responsive ">
            <div class="container-fluid">
<?php
/*
foreach ( $cart->getItems() as $item){
    echo $item->getCost() . PHP_EOL .'<br>';
}
*/?>
                <?php
                echo GridView::widget(
                    [
                        'dataProvider' => $dataProvider,
                        'summary' => false,
                        'showFooter' => true,
                        'showHeader' => true,
                        'tableOptions' => [
                            'class' => 'table table-bordered',
                            'id' => 'salary'
                        ],
                        'headerRowOptions' => [
                            'class' => 'table-light'
                        ],
                        'rowOptions' => function ($model) {
                            return ['style' => 'background-color:' . $model->getColor()];
                        },
                        'emptyText' => 'No results found',
                        'emptyTextOptions' => [
                            'tag' => 'div',
                            'class' => 'col-12 col-lg-6 mb-3 text-info'
                        ],
                        'columns' => [
                            [
                                'attribute' => 'Date',
                                'headerOptions' => ['class' => ''],
                                'value' => function ($model) {
                                    return DATE('Y-m-d', strtotime($model->getDate()));
                                },
                                'contentOptions' => [
                                    'class' => ['align-middle']
                                ],
                                'footer' => $cart->getFullProfit() - $cart->getFullSalary(),
                                'footerOptions' => ['class' => 'bg-info text-left'],
                                'format' => 'raw'
                            ],
                            [
                                'attribute' => 'Master',
                                'value' => function ($model) {
                                    return $model->getMasterName() . PHP_EOL.'<br>'.
                                        '<small>('. Html::a(
                                            Html::encode($model->getClientName()),
                                            ['core/event/view', 'id' => $model->getId()],['class'=>'text-secondary']).')</small>';

                                },
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => [
                                    'class' => ['text-center align-middle']
                                ],
                               'format' => 'raw'
                            ],
                            [
                                'attribute' => 'Service',
                                'headerOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->getServiceList();
                                },
                                'contentOptions' => [
                                    'class' => ['text-center align-middle']
                                ],
                                'visible' => true,
                                'format' => 'raw'
                            ],
                            [
                                'attribute' => 'Category',
                                'headerOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->getCategory();
                                },
                                'contentOptions' => [
                                    'class' => ['text-center align-middle']
                                ],
                                'visible' => true,
                                'format' => 'raw'
                            ],

                            [
                                'attribute' => 'Rate',
                                'headerOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->getEmployeeRate();
                                },
                                'contentOptions' => [
                                    'class' => ['text-center align-middle']
                                ],
                                'visible' => false,
                                'format' => 'raw'
                            ],
                            [
                                'attribute' => 'Price',
                                'headerOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->getEmployeePrice();
                                },
                                'contentOptions' => [
                                    'class' => ['text-center align-middle']
                                ],
                                'visible' => false,
                                'format' => 'raw'
                            ],
                            [
                                'attribute' => 'Discount',
                                'headerOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->getDiscount() . '%<br>' . DiscountHelper::discountLabel(
                                            $model->getDiscountFrom()
                                        );
                                },
                                'contentOptions' => [
                                    'class' => ['text-center align-middle']
                                ],
                                'format' => 'raw'
                            ],
                            [
                                'attribute' => 'Price',
                                'headerOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->getOriginalCost();
                                },
                                'contentOptions' => [
                                    'class' => ['text-center align-middle']
                                ],
                                'visible' => true,
                                'format' => 'raw'
                            ],
                            [
                                'attribute' => 'Price Masters',
                                'headerOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->getMasterPrice();
                                },
                                'contentOptions' => [
                                    'class' => ['text-center align-middle']
                                ],
                                'format' => 'raw'
                            ],
                            [
                                'attribute' => 'Discounted price',
                                'headerOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->getDiscountedPrice() .'<br>'. EventPaymentStatusHelper::statusLabel($model->getStatus());
                                },
                                'contentOptions' => function ($model) use ($cart) {
                                    return [
                                        'data-total' => $model->getDiscountedPrice(),
                                        'class' => ['text-center align-middle']
                                    ];
                                },
                                'footer' => $cart->getFullDiscountedCost(),
                                'footerOptions'  => ['class' => 'text-center bg-info'],
                                'format' => 'raw'
                            ],
                            [
                                'attribute' => 'Salary',
                                'headerOptions' => ['class' => 'text-center '],
                                'value' => function ($model) use ($cart) {
                                    return $model->getSalary();
                                },
                                'contentOptions' => function ($model) use ($cart) {
                                    return [
                                        'data-total' => $model->getSalary(),
                                        'class' => ['text-center align-middle text-dark']
                                    ];
                                },
                                'footer' => $cart->getFullSalary(),
                                'footerOptions'  => ['class' => 'bg-info text-center'],
                            ],
                            [
                                'attribute' => 'Profit',
                                'headerOptions' => ['class' => 'text-right '],
                                'value' => function ($model) use ($cart) {
                                    return $model->getProfit();
                                },
                                'contentOptions' => function ($model) use ($cart) {
                                    return [
                                        'data-total' => $model->getProfit(),
                                        'class' => ['text-right align-middle text-dark']
                                    ];
                                },
                                'footer' => $cart->getFullProfit(),
                                'footerOptions' => ['class' => 'bg-info text-right '],
                            ]
                        ]
                    ]
                ) ?>
            </div>

        </div>

    </div>

<?php
$js = <<< JS
 $(function () {
   let table= $('#salary').DataTable({
                bDestroy: true,
                responsive: true,
                pageLength: -1, 
                paging: true,
                lengthChange: true,
                lengthMenu: [[10, 25, 50, -1], [ 10, 25, 50,"All"]],
                searching: true,
                ordering: false,
                info: true,
                autoWidth: false,
                colReorder:{
                    realtime:false
                },
                fixedHeader: {
                    header: true,
                    footer: true
                },
                bStateSave: true,
                dom:'<"row"<"col-12"Q><"col-12"B>> t <"row"<"col-4"l><"col-4"i><"col-4"p>> ',
                footerCallback: function ( row, data, start, end, display ) {
                var api = this.api();
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                return typeof i === 'string' ?
                i.replace(/[\$,]/g, '')*1 :
                typeof i === 'number' ?
                i : 0;
                };
                
                // Total Discounted
                
                let  totalDiscounted = api
                .column( 7 )
                .nodes()
                .reduce( function (a, b) {
                return intVal(a) + intVal($(b).attr('data-total'));
                }, 0 );
                // Total over this page
              let  pageTotalDiscounted = api
                .column( 7, { page: 'current'} )
                .nodes()
                .reduce( function (a, b) {
                return intVal(a) + intVal($(b).attr('data-total'));
                }, 0 );
                // Update footer
                if ( pageTotalDiscounted === 0 ){
                $( api.column( 7 ).footer() )
                .html('-');
                }else{
                $( api.column( 7 ).footer() ).html(pageTotalDiscounted);
                }
                
                $( api.column( 7 ).footer() )
                .html( pageTotalDiscounted);
                
                
                // Total Salary
                
                let  totalSalary = api
                .column( 8 )
                .nodes()
                .reduce( function (a, b) {
                return intVal(a) + intVal($(b).attr('data-total'));
                }, 0 );
                // Total over this page
              let  pageTotalSalary = api
                .column( 8, { page: 'current'} )
                .nodes()
                .reduce( function (a, b) {
                return intVal(a) + intVal($(b).attr('data-total'));
                }, 0 );
                // Update footer
                if ( pageTotalSalary === 0 ){
                $( api.column( 8 ).footer() )
                .html('-');
                }else{
                $( api.column( 8 ).footer() ).html(pageTotalSalary);
                }
                
                $( api.column( 8 ).footer() )
                .html( pageTotalSalary);
                
                // Total Profit
                
              let  totalProfit = api
                .column( 9 )
                .nodes()
                .reduce( function (a, b) {
                return intVal(a) + intVal($(b).attr('data-total'));
                }, 0 );
                // Total over this page
              let  pageTotalProfit = api
                .column( 9, { page: 'current'} )
                .nodes()
                .reduce( function (a, b) {
                return intVal(a) + intVal($(b).attr('data-total'));
                }, 0 );
                // Update footer
                if ( pageTotalProfit === 0 ){
                $( api.column( 9 ).footer() )
                .html('-');
                }else{
                $( api.column( 9 ).footer() ).html(pageTotalProfit);
                }
                
                $( api.column( 9 ).footer() )
                .html( pageTotalProfit);
                
                },
                fnStateSave: function (oSettings, oData) {
                localStorage.setItem('DataTables_' + window.location.pathname, JSON.stringify(oData));
                },
                fnStateLoad: function () {
                var data = localStorage.getItem('DataTables_' + window.location.pathname);
                return JSON.parse(data);
                },
                searchBuilder: {
                    columns: [0,1,2]
                },
               buttons: [
                {
                    extend: 'copyHtml5',
                    //title:'111111',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                /*{
                    extend: 'csvHtml5',
                    //title:'22222',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,':visible']
                    }
                },*/
                {
                    extend: 'excelHtml5',
                    // title:'33333',
                    sheetName: 'Salary',
                    exportOptions: {
                        columns: [':visible']
                    }
                },
                /*{
                    extend: 'pdfHtml5',
                    //title:'44444',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,':visible']
                    }
                },*/
                'colvis'
            ],
                language: {
                    searchBuilder: {
                        add: 'Add filter',
                        //condition: 'Comparator',
                        //clearAll: 'Reset',
                        //delete: 'Delete',
                        //deleteTitle: 'Delete Title',
                        //data: 'Column',
                        //left: 'Left',
                        //leftTitle: 'Left Title',
                        //logicAnd: 'AND',
                        //logicOr: 'OR',
                        //right: 'Right',
                        //rightTitle: 'Right Title',
                        title: {
                            0: 'Filters',
                            _: 'Filters (%d)'
                        }
                        //value: 'Option',
                        //valueJoiner: 'et'
                    },
                    paginate: {
                        first: "First",
                        previous: '<i class="fas fa-backward"></i>',
                        last: "Last",
                        next: '<i class="fas fa-forward"></i>'
                    }
                }
    }).buttons().container().appendTo('#salary_wrapper .col-md-6:eq(0)');

   table.on("column-reorder", function(e, settings, details){
       let order = table.order();
   });
   

 });


JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

?>


