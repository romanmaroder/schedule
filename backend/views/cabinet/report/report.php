<?php


/* @var $this \yii\web\View */

/* @var $cart \core\cart\schedule\Cart */

/* @var $dataProvider \yii\data\ArrayDataProvider */


use backend\assets\DataTableAsset;
use core\helpers\EventMethodsOfPayment;
use core\helpers\EventPaymentStatusHelper;
use hail812\adminlte3\assets\PluginAsset;
use yii\grid\GridView;
use yii\helpers\Url;


$this->title = Yii::t('cabinet/report', 'Report');
$this->params['breadcrumbs'][] = ['label' => Yii::t('cabinet', 'Cabinet'), 'url' => ['/cabinet/default/index']];
$this->params['breadcrumbs'][] = $this->title;
PluginAsset::register($this)->add(
    [
        'datatables',
        'datatables-bs4',
        'datatables-responsive',
        'datatables-buttons',
        'datatables-searchbuilder',
        'datatables-fixedheader',
    ]
);
DataTableAsset::register($this);
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
                            //'class' => 'table-light'
                        ],
                        'rowOptions' => fn($model) => ['style' => 'background-color:' . $model->getColor()],
                        'emptyText' => false,
                        'columns' => [
                            [
                                'attribute' => 'Date',
                                'label' => Yii::t('cabinet/report', 'Date'),
                                'value' => fn($model) => DATE('Y-m-d', strtotime($model->getDate()))
                            ],
                            [
                                'attribute' => 'Master',
                                'label' => Yii::t('cabinet/report', 'Master'),
                                'value' => fn($model) => $model->getMasterName(),
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
                                'label' => Yii::t('cabinet/report', 'Service'),
                                'value' => fn($model) => $model->getServiceList(),
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => [
                                    'class' => ['text-center align-middle']
                                ],
                            ],
                            [
                                'attribute' => 'Price',
                                'label' => Yii::t('cabinet/report', 'Price'),
                                'value' => fn($model) => $model->getOriginalCost(),
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
                                'attribute' => 'Discounted price',
                                'label' => Yii::t('cabinet/report', 'Discounted price'),
                                'value' => fn($model) => $model->getDiscountedPrice(),
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => fn($model) => [
                                    'data-total' => $model->getDiscountedPrice(),
                                    'class' => ['text-center align-middle']
                                ],
                                'footer' => $cart->getFullDiscountedCost(),
                                'footerOptions' => ['class' => 'text-center bg-info'],
                                'format' => 'raw'
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
                                'label' => Yii::t('cabinet/report', 'Salary'),
                                'headerOptions' => ['class' => 'text-center '],
                                'value' => fn($model) => $model->getSalary(),
                                'contentOptions' => fn($model) => [
                                    'data-total' => $model->getSalary(),
                                    'class' => ['text-center align-middle text-dark']
                                ],
                                'footer' => $cart->getFullSalary(),
                                'footerOptions' => ['class' => 'bg-info text-center'],
                            ],
                            [
                                'attribute' => 'Profit',
                                'label' => Yii::t('cabinet/report', 'Profit'),
                                'headerOptions' => ['class' => 'text-right '],
                                'value' => fn($model) => $model->getProfit(),
                                'contentOptions' => fn($model) => [
                                    'data-total' => $model->getTotalProfit(),
                                    'class' => ['text-right align-middle text-dark']
                                ],
                                'footer' => $cart->getFullProfit(),
                                'footerOptions' => ['class' => 'bg-info text-right '],
                            ],
                            [
                                'attribute' => 'Status',
                                'label' => Yii::t('schedule/event', 'Status'),
                                'headerOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return EventPaymentStatusHelper::statusLabel($model->getStatus());
                                },
                                'contentOptions' => function ($model) use ($cart) {
                                    return [
                                        'data-total' => EventPaymentStatusHelper::getItem($model->getStatus()),
                                        'class' => ['text-center align-middle']
                                    ];
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'Payments',
                                'label' => Yii::t('cabinet/report','Payments'),
                                'headerOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return EventMethodsOfPayment::statusLabel($model->getPayment());
                                },
                                'contentOptions' => function ($model) use ($cart) {
                                    return [
                                        'data-total' => EventMethodsOfPayment::getItem($model->getPayment()),
                                        'class' => ['text-center align-middle']
                                    ];
                                },
                                'footer' => $cart->getFullDiscountedCost(),
                                'footerOptions' => ['class' => 'text-center bg-info'],
                                'format' => 'raw',
                            ],
                        ]
                    ]
                ); ?>
            </div>
        </div>
    </div>
<?php
$ru = Url::to('@web/js/dataTable/internationalisation/plug-ins_2_1_7_i18n_ru.json');
$js = <<< JS
$(function () {
let table= $('#report').DataTable({
                paging: true,
                lengthChange: true,
                lengthMenu: [[10, 25, 50, -1], [ 10, 25, 50,"All"]],
                searching: true,
                ordering: false,
                info: true,
                autoWidth: false,
                responsive: true,
                fixedHeader: {
                    header: true,
                    footer: true
                },
                bStateSave: true,
                dom:'<"row"<"col-12  btn-sm"Q>><"row"<"col-auto col-sm-6"B><"col-auto col-sm-6 text-right"l>> t <"row"<"col-12 mb-2 mb-md-0 col-md-6"i><"col-12 col-md-6"p>> ',
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
                .column( 4 )
                .nodes()
                .reduce( function (a, b) {
                return intVal(a) + intVal($(b).attr('data-total'));
                }, 0 );
                // Total over this page
              let  pageTotalDiscounted = api
                .column( 4, { page: 'current'} )
                .nodes()
                .reduce( function (a, b) {
                return intVal(a) + intVal($(b).attr('data-total'));
                }, 0 );
                // Update footer
                if ( pageTotalDiscounted === 0 ){
                $( api.column( 4 ).footer() )
                .html('-');
                }else{
                $( api.column( 4 ).footer() ).html(pageTotalDiscounted);
                }
                
                $( api.column( 4 ).footer() )
                .html( pageTotalDiscounted);
                
                
                // Total Salary
                
                let  totalSalary = api
                .column( 5 )
                .nodes()
                .reduce( function (a, b) {
                return intVal(a) + intVal($(b).attr('data-total'));
                }, 0 );
                // Total over this page
              let  pageTotalSalary = api
                .column( 5, { page: 'current'} )
                .nodes()
                .reduce( function (a, b) {
                return intVal(a) + intVal($(b).attr('data-total'));
                }, 0 );
                // Update footer
                if ( pageTotalSalary === 0 ){
                $( api.column( 5 ).footer() )
                .html('-');
                }else{
                $( api.column( 5 ).footer() ).html(pageTotalSalary);
                }
                
                $( api.column( 5 ).footer() )
                .html( pageTotalSalary);
                
                // Total Profit
                
              let  totalProfit = api
                .column( 6 )
                .nodes()
                .reduce( function (a, b) {
                return intVal(a) + intVal($(b).attr('data-total'));
                }, 0 );
                // Total over this page
              let  pageTotalProfit = api
                .column( 6, { page: 'current'} )
                .nodes()
                .reduce( function (a, b) {
                return intVal(a) + intVal($(b).attr('data-total'));
                }, 0 );
                // Update footer
                if ( pageTotalProfit === 0 ){
                $( api.column( 6 ).footer() )
                .html('-');
                }else{
                $( api.column( 6 ).footer() ).html(pageTotalProfit);
                }
                
                $( api.column( 6 ).footer() )
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
                    columns: [0,1,2,7,8]
                },
               buttons: [
                /*{
                    extend: 'copyHtml5',
                    //title:'111111',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },*/
                /*{
                    extend: 'csvHtml5',
                    //title:'22222',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,':visible']
                    }
                },*/
                {
                    extend: 'excelHtml5',
                     title:'',
                    //footer: true,
                    sheetName: 'Report',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6]
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
                    url: '$ru',
                },
    }).buttons().container().appendTo('#report_wrapper .col-md-6:eq(0)');

   /*table.on("column-reorder", function(e, settings, details){
       let order = table.order();
   });*/
   

 });


JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

