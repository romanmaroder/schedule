<?php



/* @var $this \yii\web\View */
/* @var $searchModel \backend\forms\Expenses\ExpenseSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */

use backend\assets\DataTableAsset;
use core\entities\Expenses\Expenses\Expenses;
use core\helpers\PriceHelper;
use hail812\adminlte3\assets\PluginAsset;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('expenses/expenses', 'Expenses');
$this->params['breadcrumbs'][] = ['label' => Yii::t('expenses/expenses', 'Expenses'), 'url' => ['index']];
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

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title ">
                                <?= Html::a(Yii::t('app','Create'), ['create'], ['class' => 'btn btn-success btn-shadow btn-sm btn-gradient']) ?>
                </h3>
                    <div class='card-tools'>
                        <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
                        </button>
                        <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
                        </button>
                    </div>
            </div>
            <div class="card-body">
                <?= GridView::widget(
                    [
                        'dataProvider' => $dataProvider,
                        //'filterModel' => $searchModel,
                        'summary' => false,
                        'showFooter' => true,
                        'tableOptions' => [
                            'class' => 'table table-striped table-bordered',
                            'id' => 'expense'
                        ],
                        'emptyText' => false,
                        'columns' => [
                            //'id',
                            [
                                'attribute' => 'category_id',
                                'value' => function (Expenses $model) {
                                    return Html::a(Html::encode($model->category->name), ['expenses/category/view', 'id' => $model->category_id]);
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'name',
                                'value' => function (Expenses $model) {
                                    return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'value',
                                'value' => function (Expenses $model) {
                                    return PriceHelper::format($model->value);
                                },
                                'contentOptions' => function ($model) {
                                    return [
                                        'data-total' => $model->value,
                                        'class' => ['text-center align-middle']
                                    ];
                                },
                                'footer' => '',
                                'footerOptions' => ['class' => 'text-center bg-info'],
                            ],
                            [
                                'attribute' => 'created_at',
                                'value' => function ($model) {
                                    return DATE('Y-m-d', $model->created_at);
                                },
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => [
                                    'class' => ['text-center align-middle']
                                ],
                                'format' => 'raw',
                            ],
                            /*[
                                'attribute' => 'status',
                                'filter' => $searchModel->statusList(),
                                'value' => function (Expenses $model) {
                                    return ExpenseHelper::statusLabel($model->status);
                                },
                                'format' => 'raw',
                                'contentOptions' => ['style' => 'text-align:center'],
                            ],*/
                        ],
                    ]
                ); ?>
            </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <!--Footer-->
                        </div>
                        <!-- /.card-footer-->
                    </div>
            </div>
        </div>
    </div>


<?php
$ru = Url::to('@web/js/dataTable/internationalisation/plug-ins_2_1_7_i18n_ru.json');
$js = <<< JS
 $(function () {
 
    $('#expense').DataTable({
       paging: true,
       pageLength: -1,
       lengthChange: true,
       lengthMenu: [[10, 25, 50, -1], [ 10, 25, 50,"All"]],
       searching: true,
       ordering: false,
       info: true,
       autoWidth: false,
       responsive: true,
       bStateSave: true,
       dom:'<"row"<"col-12 btn-sm"Q>> t <"row"<"col"l><"col"i><"col"p>> ',
                footerCallback: function ( row, data, start, end, display ) {
                var api = this.api();
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                return typeof i === 'string' ?
                i.replace(/[\$,]/g, '')*1 :
                typeof i === 'number' ?
                i : 0;
                };
                
               // Total Expenses
               
              let  totalExpenses = api
                .column( 2 )
                .nodes()
                .reduce( function (a, b) {
                return intVal(a) + intVal($(b).attr('data-total'));
                }, 0 );
              
                // Total over this page
              let  pageTotalExpenses = api
                .column( 2, { page: 'current'} )
                .nodes()
                .reduce( function (a, b) {
                return intVal(a) + intVal($(b).attr('data-total'));
                }, 0 );
                // Update footer
                if ( pageTotalExpenses === 0 ){
                $( api.column( 2 ).footer() )
                .html('-');
                }else{
                    $( api.column( 2 ).footer() ).html(pageTotalExpenses);
                }
                $( api.column( 2 ).footer() ).html( pageTotalExpenses);
                
                },
                fnStateSave: function (oSettings, oData) {
                localStorage.setItem('DataTables_' + window.location.pathname, JSON.stringify(oData));
                },
                fnStateLoad: function () {
                var data = localStorage.getItem('DataTables_' + window.location.pathname);
                return JSON.parse(data);
                },
                searchBuilder: {
                    columns: [0,1,3]
                },fixedHeader: {
                    header: true,
                    footer: true
                },
        language:{url:"$ru"}
    }).buttons().container().appendTo('#expense_wrapper .col-md-6:eq(0)');

  });

JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

?>