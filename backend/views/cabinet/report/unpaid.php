<?php


/* @var $this \yii\web\View */

/* @var $dataProvider \yii\data\ArrayDataProvider */


/* @var $cart \schedule\cart\Cart */

use hail812\adminlte3\assets\PluginAsset;
use yii\grid\GridView;
use yii\helpers\Html;


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

?>
    <div class="unpaid-index">

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
                            'class' => 'table table-striped table-bordered',
                            'id' => 'unpaid'
                        ],
                        'headerRowOptions' => [
                            'class' => 'table-light'
                        ],
                        'rowOptions' => function ($model) {
                            return ['style' => 'background-color:' . $model->getDefaultColor() ?? $model->employee->color];
                        },
                        'emptyText' => 'No results found',
                        'emptyTextOptions' => [
                            'tag' => 'div',
                            'class' => 'col-12 col-lg-6 mb-3 text-info'
                        ],
                        'columns' => [
                            [
                                'attribute' => 'Date',
                                'value' => function ($model) {
                                    return Html::a(
                                        Html::encode(DATE('Y-m-d', strtotime($model->start))),
                                        ['schedule/event/view', 'id' => $model->id]
                                    );
                                },
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => [
                                    'class' => ['text-center align-middle']
                                ],
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'Master',
                                'value' => function ($model) {
                                    return $model->employee->user->username ?? $model->getFullName();
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
                                },
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => [
                                    'class' => ['text-center align-middle']
                                ],
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
                                'value' => function ($model) use ($cart) {
                                    return $model->getDiscountedPrice($model, $cart);
                                },
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => function ($model) use ($cart) {
                                    return [
                                        'data-total' => $model->getDiscountedPrice($model, $cart),
                                        'class' => ['text-center align-middle text-dark']
                                    ];
                                },
                                //'footer' => '',
                                'footerOptions' => ['class' => 'bg-info text-center'],
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
let table= $('#unpaid').DataTable({
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
        dom:'<"row"<"col-12"Q>> t <"row"<"col"l><"col"i><"col"p>> ',
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
      let  totalDebt = api
        .column( 4 )
        .nodes()
        .reduce( function (a, b) {
        return intVal(a) + intVal($(b).attr('data-total'));
        }, 0 );
        // Total over this page
      let  pageTotalDebt = api
        .column( 4, { page: 'current'} )
        .nodes()
        .reduce( function (a, b) {
        return intVal(a) + intVal($(b).attr('data-total'));
        }, 0 );
        // Update footer
        if ( pageTotalDebt === 0 ){
        $( api.column( 4 ).footer() )
        .html('-');
        }else{
        $( api.column( 4 ).footer() ).html(pageTotalDebt);
        }
        
        $( api.column( 4 ).footer() )
        .html( pageTotalDebt);
        
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
            }).buttons().container().appendTo('#unpaid_wrapper .col-md-6:eq(0)');
        
           /*table.on("column-reorder", function(e, settings, details){
               let order = table.order();
           });*/
           

 });


JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

