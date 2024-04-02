<?php


/* @var $this \yii\web\View */

/* @var $expenses \yii\data\DataProviderInterface */


use hail812\adminlte3\assets\PluginAsset;
use yii\grid\GridView;

$this->title = 'Expenses';
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
                                'value' => function ($model) {
                                    return DATE('Y-m-d', $model->created_at);
                                },
                                'format' => 'raw'
                            ],
                            [
                                'attribute' => 'category_id',
                                'value' => function ($model) {
                                    return $model->category->name;
                                },
                                'contentOptions' => function ($model) {
                                    return [
                                        'data-total' => $model->value,
                                    ];
                                },
                            ],

                            'name',
                            [
                                'attribute' => 'value',
                                'value' => function ($model) {
                                    return $model->value;
                                },
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
$js = <<< JS
$(function () {
let table= $('#expenses').DataTable({
bDestroy: true,
responsive: true,
pageLength: 10,
paging: true,
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
                    columns: [0,2,3]
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
                        columns: [0,1,2,3,':visible']
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
                        columns: [0,1,2,3,':visible']
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
                    lengthMenu: 'Show <select class="form-control form-control-sm">'+
                    '<option value="10">10</option>'+
                    '<option value="20">20</option>'+
                    '<option value="50">50</option>'+
                    '<option value="-1">All</option>'+
                    '</select>',
                    paginate: {
                first: "First",
                previous: '<i class="fas fa-backward"></i>',
                last: "Last",
                next: '<i class="fas fa-forward"></i>'
                }
               }
    }).buttons().container().appendTo('#expenses_wrapper .col-md-6:eq(0)');

   /*table.on("column-reorder", function(e, settings, details){
       let order = table.order();
   });*/
   

 });


JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);