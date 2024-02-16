<?php

/* @var $this yii\web\View */

/* @var $cart \schedule\cart\Cart */

/* @var $dataProvider */

use hail812\adminlte3\assets\PluginAsset;
use yii\grid\GridView;

$this->title = 'Salary';
$this->params['breadcrumbs'][] = ['label' => 'Cabinet', 'url' => ['/cabinet/default/index']];
$this->params['breadcrumbs'][] = $this->title;

PluginAsset::register($this)->add(
    ['datatables', 'datatables-bs4', 'datatables-responsive', 'datatables-buttons','datatables-colreorder']
);


?>
    <div class="cabinet-index">

        <div class="table-responsive ">
            <div class="container-fluid">

                <?php
                echo GridView::widget(
                    [
                        'dataProvider' => $dataProvider,
                        'summary'=>false,
                        'showFooter' => true,
                        'showHeader' => true,
                        'tableOptions' => [
                            'class' => 'table table-striped',
                            'id' => 'salary'
                        ],
                        'headerRowOptions' => [
                                'class'=>'table-light'
                        ],
                        'emptyText' => 'No results found',
                        'emptyTextOptions' => [
                            'tag' => 'div',
                            'class' => 'col-12 col-lg-6 mb-3 text-info'
                        ],
                        'columns' => [
                            [
                                'attribute' => 'Date',
                                'headerOptions' => ['class' => ''],
                                'contentOptions' => [
                                    'class' => ['']
                                ],
                                'value' => function ($model) {
                                    return DATE('Y-m-d', strtotime($model->getEvents()->start));
                                },
                                'footer' => $cart->getFullSalary(),
                                'footerOptions' => ['class' => 'bg-info text-left'],
                            ],
                            [
                                'attribute' => 'Services',
                                'headerOptions' => ['class' => 'text-left'],
                                'value' => function ($model) {
                                    return $model->getServiceList();
                                },
                                //'footer' => $cart->getPrice(),
                                'format' => 'raw'
                            ],
                            [
                                'attribute' => 'Price',
                                'headerOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->getPriceList();
                                },
                                'contentOptions' => [
                                    'class' => ['text-center align-middle']
                                ],
                                'format' => 'raw'
                            ],
                            [
                                'attribute' => 'Total',
                                'headerOptions' => ['class' => 'text-center'],
                                'value' => function ($model) use ($cart) {
                                    return $model->getTotalPrice();
                                },
                                'contentOptions' => [
                                    'class' => ['text-center align-middle']
                                ]
                            ],
                            [
                                'attribute' => 'Client discount',
                                'headerOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->getDiscount() .'%';
                                },
                                'contentOptions' => [
                                    'class' => ['text-center align-middle']
                                ]
                            ],
                            [
                                'attribute' => 'Cost',
                                'headerOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->getCost();
                                },
                                'contentOptions' => function ($model) use ($cart) {
                                    return [
                                        'data-total' => $model->getCost(),
                                        'class' => ['text-center align-middle']
                                    ];
                                },
                                'footerOptions'  => ['class' => 'text-center bg-info'],
                            ],
                            [
                                'attribute' => 'Salary',
                                'headerOptions' => ['class' => 'text-right '],
                                'value' => function ($model) use ($cart) {
                                    return $model->getSalary();
                                },
                                'contentOptions' => function ($model) use ($cart) {
                                    return [
                                        'data-total' => $model->getSalary(),
                                        'class' => ['text-right align-middle text-info']
                                    ];
                                },
                                'footer' => $cart->getFullSalary(),
                                'footerOptions'  => ['class' => 'bg-info text-right '],
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
                "bDestroy": true,
                "responsive": true,
                "pageLength": 10,
                "paging": true,
                "searching": true,
                "ordering": false,
                "info": false,
                "autoWidth": false,
                "colReorder":{
                    "realtime":true
                },
                "bStateSave": true,         "dom": "<'row'<'col-12 col-sm-6 d-flex align-content-md-start'f><'col-12 col-sm-6 d-flex justify-content-sm-end'l>>tp",
                "footerCallback": function ( row, data, start, end, display ) {
                            var api = this.api();
                            // Remove the formatting to get integer data for summation
                            var intVal = function ( i ) {
                                return typeof i === 'string' ?
                                    i.replace(/[\$,]/g, '')*1 :
                                    typeof i === 'number' ?
                                        i : 0;
                            };
                            // Total over all pages
                            totalPriceWithDiscount = api
                                .column( 5 )
                                .nodes()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal($(b).attr('data-total'));
                                }, 0 );
                            // Total over this page
                            pageTotalPriceWithDiscount = api
                                .column( 5, { page: 'current'} )
                                .nodes()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal($(b).attr('data-total'));
                                }, 0 );
                            // Update footer
                            $( api.column( 5 ).footer() )
                            .html( pageTotalPriceWithDiscount);
                            // Total over all pages
                            totalSalary = api
                                .column( 6 )
                                .nodes()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal($(b).attr('data-total'));
                                }, 0 );
                            // Total over this page
                            pageTotalSalary = api
                                .column( 6, { page: 'current'} )
                                .nodes()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal($(b).attr('data-total'));
                                }, 0 );
                            // Update footer
                            if ( pageTotalSalary === 0 ){
                                 $( api.column( 6 ).footer() )
                                 .html('-');
                            }else{
                                 $( api.column( 6 ).footer() ).html(pageTotalSalary);
                            }

                            //

                             /*var diffPage =  pageTotalPrice - pageTotalSalary;
                             var diffTotal =  totalPrice - totalSalary;*/
                            $( api.column( 0 ).footer() )
                            .html( pageTotalSalary);

                        },
                "fnStateSave": function (oSettings, oData) {
                localStorage.setItem('DataTables_' + window.location.pathname, JSON.stringify(oData));
                },
                "fnStateLoad": function () {
                var data = localStorage.getItem('DataTables_' + window.location.pathname);
                return JSON.parse(data);
                },
                "language": {
                "lengthMenu": 'Show <select class="form-control form-control-sm">'+
                    '<option value="10">10</option>'+
                    '<option value="20">20</option>'+
                    '<option value="50">50</option>'+
                    '<option value="-1">All</option>'+
                    '</select>',
                "search": "Search:",
                "zeroRecords": "No match found",
                "emptyTable": "There is no data in the table",
                "paginate": {
                "first": "First",
                "previous": '<i class="fas fa-backward"></i>',
                "last": "Last",
                "next": '<i class="fas fa-forward"></i>'
                }
                },
    }).buttons().container().appendTo('#salary_wrapper .col-md-6:eq(0)');

   table.on("column-reorder", function(e, settings, details){
       let order = table.order();
   })

 });


JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

?>