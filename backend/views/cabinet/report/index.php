<?php

/* @var $this yii\web\View */

/* @var $cart \core\cart\schedule\Cart */

/* @var $model \core\cart\schedule\CartItem */

/* @var $events \core\entities\Schedule\Event\Event */

/* @var $dataProvider \yii\data\ArrayDataProvider */


use backend\assets\DataTableAsset;
use core\helpers\DiscountHelper;
use core\helpers\EventPaymentStatusHelper;
use hail812\adminlte3\assets\PluginAsset;
use kartik\widgets\DatePicker;
use yii\bootstrap4\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

//use kartik\grid\GridView;

$this->title = Yii::t('cabinet/report', 'Salary');
$this->params['breadcrumbs'][] = ['label' => Yii::t('cabinet', 'Cabinet'), 'url' => ['/cabinet/default/index']];
$this->params['breadcrumbs'][] = $this->title;

PluginAsset::register($this)->add(
    [
        'datatables',
        'datatables-bs4',
        'datatables-responsive',
        'datatables-buttons',
        //'datatables-colreorder',
        'datatables-searchbuilder',
        'datatables-fixedheader',
    ]
);
DataTableAsset::register($this);
?>
    <div class="salary-index">

        <div class="table-responsive ">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">

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
                                    //'class' => 'table-light'
                                ],
                                'rowOptions' => fn($model) => ['style' => 'background-color:' . $model->getColor()],
                                'emptyText' => false,
                                'columns' => [
                                    [
                                        'label' => Yii::t('cabinet/report', 'Date'),
                                        'headerOptions' => ['class' => ''],
                                        'value' => fn ($model) =>
                                             DATE('Y-m-d', strtotime($model->getDate())),
                                        'contentOptions' => [
                                            'class' => ['align-middle']
                                        ],
                                        'footer' => $cart->getFullProfit() - $cart->getFullSalary(),
                                        'footerOptions' => ['class' => 'bg-info text-left'],
                                        'format' => 'raw'
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
                                    [
                                        'attribute' => 'Service',
                                        'label' => Yii::t('cabinet/report', 'Service'),
                                        'headerOptions' => ['class' => 'text-center'],
                                        'value' => fn($model) => $model->getServiceList(),
                                        'contentOptions' => [
                                            'class' => ['text-center align-middle']
                                        ],
                                        'visible' => true,
                                        'format' => 'raw'
                                    ],
                                    [
                                        'attribute' => 'Client',
                                        'label' => Yii::t('cabinet/report', 'Client'),
                                        'value' => fn($model) => Html::a(
                                            Html::encode($model->getClientName()),
                                            ['schedule/event/view', 'id' => $model->getId()],
                                            ['class' => 'text-secondary']
                                        ),
                                        'headerOptions' => ['class' => 'text-center'],
                                        'contentOptions' => [
                                            'class' => ['text-center align-middle']
                                        ],
                                        'format' => 'raw'
                                    ],
                                    [
                                        'attribute' => 'Discount',
                                        'label' => Yii::t('cabinet/report', 'Discount'),
                                        'headerOptions' => ['class' => 'text-center'],
                                        'value' => fn($model) => $model->getDiscount(
                                            ) . '%<br>' . DiscountHelper::discountLabel(
                                                $model->getDiscountFrom()
                                            ),
                                        'contentOptions' => [
                                            'class' => ['text-center align-middle']
                                        ],
                                        'format' => 'raw'
                                    ],
                                    [
                                        'attribute' => 'Price',
                                        'label' => Yii::t('cabinet/report', 'Price'),
                                        'headerOptions' => ['class' => 'text-center'],
                                        'value' => fn($model) => $model->getOriginalCost(),
                                        'contentOptions' => [
                                            'class' => ['text-center align-middle']
                                        ],
                                        'visible' => false,
                                        'format' => 'raw'
                                    ],
                                    [
                                        'attribute' => 'Price Masters',
                                        'label' => Yii::t('cabinet/report', 'Price Masters'),
                                        'headerOptions' => ['class' => 'text-center'],
                                        'value' => fn($model) => $model->getMasterPrice(),
                                        'contentOptions' => [
                                            'class' => ['text-center align-middle']
                                        ],
                                        'format' => 'raw'
                                    ],
                                    [
                                        'attribute' => 'Discounted price',
                                        'label' => Yii::t('cabinet/report', 'Discounted price'),
                                        'headerOptions' => ['class' => 'text-center'],
                                        'value' => fn($model) => $model->getDiscountedPrice(
                                            ) . '<br>' . EventPaymentStatusHelper::statusLabel($model->getStatus()),
                                        'contentOptions' => fn($model) => [
                                            'data-total' => $model->getDiscountedPrice(),
                                            'class' => ['text-center align-middle']
                                        ],
                                        'footer' => $cart->getFullDiscountedCost(),
                                        'footerOptions' => ['class' => 'text-center bg-info'],
                                        'format' => 'raw'
                                    ],
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
                                ],
                            ]
                        ) ?></div>
                </div>


            </div>

        </div>

    </div>

<?php
$ru = Url::to('@web/js/dataTable/internationalisation/plug-ins_2_1_7_i18n_ru.json');


$js = <<< JS
 $(function () {
  
   let table= $('#salary').DataTable({
                responsive: true,
                deferRender:true,
                pageLength: 10,
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
                .column( 6 )
                .nodes()
                .reduce( function (a, b) {
                return intVal(a) + intVal($(b).attr('data-total'));
                }, 0 );
                // Total over this page
              let  pageTotalDiscounted = api
                .column( 6, { page: 'current'} )
                .nodes()
                .reduce( function (a, b) {
                return intVal(a) + intVal($(b).attr('data-total'));
                }, 0 );
                // Update footer
                if ( pageTotalDiscounted === 0 ){
                $( api.column( 6 ).footer() )
                .html('-');
                }else{
                $( api.column( 6 ).footer() ).html(pageTotalDiscounted);
                }

                $( api.column( 6 ).footer() )
                .html( pageTotalDiscounted);


                // Total Salary

                let  totalSalary = api
                .column( 7 )
                .nodes()
                .reduce( function (a, b) {
                return intVal(a) + intVal($(b).attr('data-total'));
                }, 0 );
                // Total over this page
              let  pageTotalSalary = api
                .column( 7, { page: 'current'} )
                .nodes()
                .reduce( function (a, b) {
                return intVal(a) + intVal($(b).attr('data-total'));
                }, 0 );
                // Update footer
                if ( pageTotalSalary === 0 ){
                $( api.column( 7 ).footer() )
                .html('-');
                }else{
                $( api.column( 7 ).footer() ).html(pageTotalSalary);
                }

                $( api.column( 7 ).footer() )
                .html( pageTotalSalary);

                // Total Profit

              let  totalProfit = api
                .column( 8 )
                .nodes()
                .reduce( function (a, b) {
                return intVal(a) + intVal($(b).attr('data-total'));
                }, 0 );
                // Total over this page
              let  pageTotalProfit = api
                .column( 8, { page: 'current'} )
                .nodes()
                .reduce( function (a, b) {
                return intVal(a) + intVal($(b).attr('data-total'));
                }, 0 );
                // Update footer
                if ( pageTotalProfit === 0 ){
                $( api.column( 8 ).footer() )
                .html('-');
                }else{
                $( api.column( 8 ).footer() ).html(pageTotalProfit);
                }

                $( api.column( 8 ).footer() )
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
                    columns: [0,1,2,3]
                },
               buttons: [
               /* {
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
                    url: '$ru',
                },
    }).buttons().container().appendTo('#salary_wrapper .col-md-6:eq(0)');

   /*table.on("column-reorder", function(e, settings, details){
       let order = table.order();
   });*/

 });


JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

?>