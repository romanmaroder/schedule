<?php


/* @var $this \yii\web\View */

/* @var $dataProvider \yii\data\ArrayDataProvider */


/* @var $cart \core\cart\schedule\Cart */

use backend\assets\DataTableAsset;
use hail812\adminlte3\assets\PluginAsset;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;


$this->title = Yii::t('cabinet/report', 'Unpaid');
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
                            // 'class' => 'table-light'
                        ],
                        'rowOptions' => fn($model) => ['style' => 'background-color:' . $model->getDefaultColor()],
                        'emptyText' => false,
                        'columns' => [
                            [
                                'attribute' => 'Date',
                                'label' => Yii::t('cabinet/report', 'Date'),
                                'value' => fn($model) => DATE('Y-m-d', strtotime($model->start)),
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => [
                                    'class' => ['text-center align-middle']
                                ],
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'Master',
                                'label' => Yii::t('cabinet/report', 'Master'),
                                'value' => fn($model) => Html::a(
                                    Html::encode($model->getFullName()),
                                    ['schedule/event/view', 'id' => $model->id],
                                    ['class' => 'text-dark']
                                ),
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => [
                                    'class' => ['text-center align-middle']
                                ],
                                'format' => 'raw'
                            ],
                            [
                                'attribute' => 'Client',
                                'label' => Yii::t('cabinet/report', 'Client'),
                                'value' => fn($model) => $model->client->username,
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => [
                                    'class' => ['text-center align-middle']
                                ],
                            ],
                            [
                                'attribute' => 'Service',
                                'label' => Yii::t('cabinet/report', 'Service'),
                                'value' => fn($model) => implode(
                                    ', </br>',
                                    ArrayHelper::getColumn($model->services, 'name')
                                ),
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => [
                                    'class' => ['text-center align-middle']
                                ],
                            ],
                            [
                                'attribute' => 'Debt',
                                'label' => Yii::t('cabinet/report', 'Debt'),
                                'value' => fn($model) => $model->getDiscountedPrice($model, $cart),
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => fn($model) => [
                                    'data-total' => $model->getDiscountedPrice($model, $cart),
                                    'class' => ['text-center align-middle text-dark']
                                ],
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
$ru = Url::to('@web/js/dataTable/internationalisation/plug-ins_2_1_7_i18n_ru.json');
$js = <<< JS
$(function () {
let table= $('#unpaid').DataTable({
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
                    url: '$ru',
                },
            }).buttons().container().appendTo('#unpaid_wrapper .col-md-6:eq(0)');
        
           /*table.on("column-reorder", function(e, settings, details){
               let order = table.order();
           });*/
           

 });


JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

