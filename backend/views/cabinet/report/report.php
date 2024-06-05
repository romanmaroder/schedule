<?php


/* @var $this \yii\web\View */

/* @var $cart \core\cart\Cart */

/* @var $dataProvider \yii\data\ArrayDataProvider */


use hail812\adminlte3\assets\PluginAsset;
use yii\grid\GridView;


$this->title = 'Report';
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
<div class="report-index">

    <div class="table-responsive ">
        <div class="container-fluid">


            <?php
            echo GridView::widget(
                [
                    'dataProvider' => $dataProvider,
                    'summary' => false,
                    'showFooter' => true,
                    'showHeader' => true,
                    'tableOptions' => [
                        'class' => 'table table-bordered',
                        'id' => 'report'
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
                            'value' => function ($model) use ($cart) {
                                return DATE('Y-m-d', strtotime($model->getDate()));
                            }
                        ],
                        [
                            'attribute' => 'Master',
                            'value' => function ($model) {
                                return $model->getMasterName();
                            },
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => [
                                'class' => ['text-center align-middle']
                            ],
                            'format' => 'raw'
                        ],
                        /*[
                            'attribute' => 'Client',
                            'value' => function ($model) {
                                return $model->getClientName();
                            }
                        ],*/
                        [
                            'attribute' => 'Service',
                            'value' => function ($model) {
                                return $model->getServiceList();
                            },
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => [
                                'class' => ['text-center align-middle']
                            ],
                        ],
                        [
                            'attribute' => 'Origin Price',
                            'value' => function ($model) use ($cart) {
                                return $model->getOriginalPrice();
                            },
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => [
                                'class' => ['text-center align-middle']
                            ],
                        ],
                        /*[
                            'attribute' => 'Discount',
                            'value' => function ($model) use ($cart) {
                                return $model->getDiscount();
                            },
                        ],*/
                        [
                            'attribute' => 'Cost With Discount',
                            'value' => function ($model) use ($cart) {
                                return $model->getDiscountedPrice();
                            },
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => [
                                'class' => ['text-center align-middle']
                            ],
                        ],
                        /*[
                            'attribute' => 'Master Price',
                            'value' => function ($model) use ($cart) {
                                return $model->getMasterPrice();
                            },
                        ],/*
                        [
                            'attribute' => 'Rate',
                            'value' => function ($model) use ($cart) {
                                return $model->getEmployeeRate();
                            },
                        ],*/
                        [
                            'attribute' => 'Salary',
                            'value' => function ($model) use ($cart) {
                                return $model->getSalary();
                            },
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => [
                                'class' => ['text-center align-middle']
                            ],
                        ],
                        [
                            'attribute' => 'Profit',
                            'headerOptions' => ['class' => 'text-right '],
                            'value' => function ($model) use ($cart) {
                                return $model->getProfit();
                            },
                            'contentOptions' => function ($model) use ($cart) {
                                return [
                                    'data-total' => $model->getTotalProfit(),
                                    'class' => ['text-right align-middle text-dark']
                                ];
                            },
                            'footer' => $cart->getFullProfit(),
                            'footerOptions' => ['class' => 'bg-info text-right '],
                        ]
                    ]
                ]
            ); ?>
        </div>
    </div>
</div>
<?php
$js = <<< JS
$(function () {
let table= $('#report').DataTable({
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
                dom:'<"row"<"col-12"Q><"col-12"B>> t <"row"<"col"l><"col"i><"col"p>> ',
//                footerCallback: function ( row, data, start, end, display ) {
//                            var api = this.api();
//                            // Remove the formatting to get integer data for summation
//                            var intVal = function ( i ) {
//                                return typeof i === 'string' ?
//                                    i.replace(/[\$,]/g, '')*1 :
//                                    typeof i === 'number' ?
//                                        i : 0;
//                            };
//                         
//                            // Total over all pages
//                            totalSalary = api
//                                .column( 5 )
//                                .nodes()
//                                .reduce( function (a, b) {
//                                    return intVal(a) + intVal($(b).attr('data-total'));
//                                }, 0 );
//                            // Total over this page
//                            pageTotalSalary = api
//                                .column( 5, { page: 'current'} )
//                                .nodes()
//                                .reduce( function (a, b) {
//                                    return intVal(a) + intVal($(b).attr('data-total'));
//                                }, 0 );
//                            // Update footer
//                            if ( pageTotalSalary === 0 ){
//                                 $( api.column( 5 ).footer() )
//                                 .html('-');
//                            }else{
//                                 $( api.column( 5 ).footer() ).html(pageTotalSalary);
//                            }
//                            
//                            $( api.column( 0 ).footer() )
//                            .html( pageTotalSalary);
//
//                        },
                fnStateSave: function (oSettings, oData) {
                localStorage.setItem('DataTables_' + window.location.pathname, JSON.stringify(oData));
                },
                fnStateLoad: function () {
                var data = localStorage.getItem('DataTables_' + window.location.pathname);
                return JSON.parse(data);
                },
                searchBuilder: {
                    columns: [0,1,2,3]
                },
               buttons: [
                {
                    extend: 'copyHtml5',
                    //title:'111111',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'csvHtml5',
                    //title:'22222',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    // title:'33333',
                    exportOptions: {
                        columns: [':visible']
                    }
                },
                {
                    extend: 'pdfHtml5',
                    //title:'44444',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,':visible']
                    }
                },
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
    }).buttons().container().appendTo('#report_wrapper .col-md-6:eq(0)');

   /*table.on("column-reorder", function(e, settings, details){
       let order = table.order();
   });*/
   

 });


JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

