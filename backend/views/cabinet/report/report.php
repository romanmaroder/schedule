<?php


/* @var $this \yii\web\View */

/* @var $cart \core\cart\schedule\Cart */

/* @var $dataProvider \yii\data\ArrayDataProvider */


use hail812\adminlte3\assets\PluginAsset;
use yii\grid\GridView;
use yii\helpers\Url;


$this->title = Yii::t('cabinet/report','Report');
$this->params['breadcrumbs'][] = ['label' =>  Yii::t('cabinet','Cabinet'), 'url' => ['/cabinet/default/index']];
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
?>
<?=  \common\widgets\preloader\PreloaderWidget::widget(); ?>
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
                    'rowOptions' => function ($model) {
                        return ['style' => 'background-color:' . $model->getColor()];
                    },
                    'emptyText' => false,
                    'columns' => [
                        [
                            'attribute' => 'Date',
                            'label' => Yii::t('cabinet/report', 'Date'),
                            'value' => function ($model) use ($cart) {
                                return DATE('Y-m-d', strtotime($model->getDate()));
                            }
                        ],
                        [
                            'attribute' => 'Master',
                            'label' => Yii::t('cabinet/report','Master'),
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
                            'label' => Yii::t('cabinet/report','Service'),
                            'value' => function ($model) {
                                return $model->getServiceList();
                            },
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => [
                                'class' => ['text-center align-middle']
                            ],
                        ],
                        [
                            'attribute' => 'Price',
                            'label' => Yii::t('cabinet/report','Price'),
                            'value' => function ($model) use ($cart) {
                                return $model->getOriginalCost();
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
                            'attribute' => 'Discounted price',
                            'label' => Yii::t('cabinet/report','Discounted price'),
                            'value' => function ($model) {
                                    return $model->getDiscountedPrice();
                            },
                            'headerOptions' => ['class' => 'text-center'],
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
                            'label' => Yii::t('cabinet/report','Salary'),
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
                            'label' => Yii::t('cabinet/report','Profit'),
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
                bDestroy: true,
                dom:'<"row"<"col-12"Q><"col-12"B>> t <"row"<"col"l><"col"i><"col"p>> ',
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

