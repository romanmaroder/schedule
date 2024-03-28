<?php


/* @var $this \yii\web\View */

/* @var $dataProvider \yii\data\ArrayDataProvider */

use hail812\adminlte3\assets\PluginAsset;
use yii\grid\GridView;


$this->title = 'Unpaid';
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


echo GridView::widget(
    [
        'dataProvider' => $dataProvider,
        'summary' => false,
        'showFooter' => true,
        'showHeader' => true,
        'tableOptions' => [
            'class' => 'table table-striped table-bordered',
            'id' => 'unpaid'
        ],
        'headerRowOptions' => [
            'class' => 'table-light'
        ],
        'rowOptions' => function ($model) {
            return ['style' => 'background-color:' . $model->employee->color];
        },
        'emptyText' => 'No results found',
        'emptyTextOptions' => [
            'tag' => 'div',
            'class' => 'col-12 col-lg-6 mb-3 text-info'
        ],
        'columns' => [
            'id',
            [
                'attribute' => 'Date',
                'value' => function ($model) {
                    return DATE('Y-m-d', strtotime($model->start));
                }
            ],
            [
                'attribute' => 'Master',
                'value' => function ($model) {
                    return $model->employee->user->username;
                },
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => [
                    'class' => ['text-center align-middle']
                ],
            ],
            [
                'attribute' => 'Client',
                'value' => function ($model) {
                    return $model->client->username;
                }
            ],
            [
                'attribute' => 'Service',
                'value' => function ($model) {
                    $name = '';
                    foreach ($model->services as $item) {
                        $name .= $item->name . ', ';
                    }
                    return $name;
                },
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => [
                    'class' => ['text-center align-middle']
                ],
            ],
            [
                'attribute' => 'Debt',
                'value' => function ($model) {
                    return $model->amount;
                }
            ]
        ]
    ]
);


$js = <<< JS
 $(function () {
   let table= $('#unpaid').DataTable({
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
    }).buttons().container().appendTo('#unpaid_wrapper .col-md-6:eq(0)');

   /*table.on("column-reorder", function(e, settings, details){
       let order = table.order();
   });*/
   

 });


JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

