<?php


/* @var $this \yii\web\View */

/* @var $expenses \yii\data\DataProviderInterface */


use backend\assets\DataTableAsset;
use hail812\adminlte3\assets\PluginAsset;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('cabinet/report', 'Expenses');
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
    <div class="expenses-index">

        <div class="table-responsive ">
            <div class="container-fluid">
                <?php
                echo GridView::widget(
                    [
                        'dataProvider' => $expenses,
                        'summary' => false,
                        'showFooter' => true,
                        'showHeader' => true,

                        'tableOptions' => [
                            'class' => 'table table-bordered table-striped text-center',
                            'id' => 'expenses'
                        ],
                        'columns' => [
                            [
                                'attribute' => 'created_at',
                                'value' => fn($model) => DATE('Y-m-d', $model->created_at),
                                'format' => 'raw'
                            ],
                            [
                                'attribute' => 'category_id',
                                'value' => fn($model) => Html::a(
                                    Html::encode($model->category->name),
                                    ['expenses/expense/view', 'id' => $model->id]
                                ),
                                'contentOptions' => fn($model) => [
                                    'data-total' => $model->value,
                                ],
                                'format' => 'raw'
                            ],

                            'name',
                            [
                                'attribute' => 'value',
                                'value' => fn ($model) =>$model->value,
                                'contentOptions' => function ($model) {
                                    return [
                                        'data-total' => $model->value,
                                        'class' => ['text-center align-middle']
                                    ];
                                },
                                //'footer' =>',
                                'footerOptions' => ['class' => 'text-center bg-info'],
                                'format' => 'raw'
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
let table= $('#expenses').DataTable({
responsive: true,
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
                         
                            // Total over all pages
                            totalSalary = api
                                .column( 3 )
                                .nodes()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal($(b).attr('data-total'));
                                }, 0 );
                            // Total over this page
                            pageTotalSalary = api
                                .column( 3, { page: 'current'} )
                                .nodes()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal($(b).attr('data-total'));
                                }, 0 );
                            // Update footer
                            if ( pageTotalSalary === 0 ){
                                 $( api.column( 3 ).footer() )
                                 .html('-');
                            }else{
                                 $( api.column( 3 ).footer() ).html(pageTotalSalary);
                            }
                            
                            $( api.column( 3 ).footer() )
                            .html( pageTotalSalary);

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
                        columns: [0,1,2,3,':visible']
                    }
                },*/
                {
                    extend: 'excelHtml5',
                    // title:'33333',
                    exportOptions: {
                        columns: [':visible']
                    }
                },
                /*{
                    extend: 'pdfHtml5',
                    //title:'44444',
                    exportOptions: {
                        columns: [0,1,2,3,':visible']
                    }
                },*/
                'colvis'
            ],
            language: {
                    url: '$ru',
                },
    }).buttons().container().appendTo('#expenses_wrapper .col-md-6:eq(0)');

   /*table.on("column-reorder", function(e, settings, details){
       let order = table.order();
   });*/
   

 });


JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);