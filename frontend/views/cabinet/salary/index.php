<?php
/* @var $this yii\web\View */

/* @var $cart \core\cart\schedule\Cart */

/* @var $dataProvider \yii\data\ArrayDataProvider */

use hail812\adminlte3\assets\PluginAsset;
use core\helpers\DiscountHelper;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Yii::t('cabinet/report','Salary');
$this->params['breadcrumbs'][] = ['label' => Yii::t('cabinet','Cabinet'), 'url' => ['/cabinet/default/index']];
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
    <div class="salary-index">

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
                            'id' => 'salary'
                        ],
                        'headerRowOptions' => [
                            'class' => 'table-light'
                        ],
                        'rowOptions' => function ($model) {
                            return ['style' => 'background-color:' . $model->getColor()];

                        },
                        'emptyText' => 'No results found',
                        'emptyTextOptions' => [
                            'tag' => 'div',
                            'class' => 'col-12 col-lg-6 mb-3 text-info'
                        ],
                        'columns' => [
                            [
                                'attribute' => 'Date',
                                'label' => Yii::t('cabinet/report','Date'),
                                'headerOptions' => ['class' => ''],
                                'value' => function ($model) {
                                    return DATE('Y-m-d', strtotime($model->getDate()));
                                },
                                'contentOptions' => function ($model) use ($cart) {
                                    return [
                                        'data-total' => $model->getSalary(),
                                        'class' => ['text-center align-middle']
                                    ];
                                },
                                'footer' => $cart->getFullSalary(),
                                'footerOptions'  => ['class' => 'bg-primary bg-gradient text-center '],
                            ],
                            [
                                'attribute' => 'Price',
                                'label' => Yii::t('cabinet/report','Price'),
                                'headerOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->getMasterPrice();
                                },
                                'contentOptions' => [
                                    'class' => ['text-center align-middle']
                                ],
                                'format' => 'raw'
                            ],
                            [
                                'attribute' => 'Salary',
                                'label' => Yii::t('cabinet/report','Salary'),
                                'headerOptions' => ['class' => 'text-center'],
                                'value' => function ($model) use ($cart) {
                                    return $model->getSalary();
                                },
                                'contentOptions' => function ($model) use ($cart) {
                                    return [
                                        //'data-total' => $model->getSalary(),
                                        'class' => ['text-center align-middle ']
                                    ];
                                },
                                /*'footer' => $cart->getFullSalary(),
                                'footerOptions'  => ['class' => 'bg-info text-center '],*/
                            ],
                            [
                                'attribute' => 'Discounted price',
                                'label' => Yii::t('cabinet/report','Discounted price'),
                                'headerOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->getDiscountedPrice();
                                },
                                'contentOptions' => [
                                    'class' => ['text-center align-middle']
                                ]
                            ],
                            [
                                'attribute' => 'Service',
                                'label' => Yii::t('cabinet/report','Service'),
                                'headerOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->getServiceList();
                                },
                                'contentOptions' => [
                                    'class' => ['text-center align-middle']
                                ],
                                //'footer' => $cart->getPrice(),
                                'format' => 'raw'
                            ],
                            [
                                'attribute' => 'Discount',
                                'label' => Yii::t('cabinet/report','Discount'),
                                'headerOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->getDiscount() .'%<br>' . DiscountHelper::discountLabel($model->getDiscountFrom());
                                },
                                'contentOptions' => [
                                    'class' => ['text-center align-middle']
                                ],'format' => 'raw'
                            ],
                        ]
                    ]
                ) ?>
            </div>

        </div>

    </div>

<?php
$ru = Url::to('@web/js/dataTable/internationalisation/plug-ins_2_1_7_i18n_ru.json');
$js = <<< JS
 $(function () {
   let table= $('#salary').DataTable({
                bDestroy: true,
                responsive: true,
                pageLength: -1,
                paging: true,
                searching: true,
                ordering: false,
                info: true,
                autoWidth: false,
                lengthChange: true,
                lengthMenu: [[10, 25, 50, -1], [ 10, 25, 50,"All"]],
                colReorder:{
                    realtime:false
                },
                fixedHeader: {
                    header: true,
                    footer: true
                },
                bStateSave: true,
                dom:'<"row"<"col-12"Q>> t <"row"<"col-4"l><"col-4"i><"col-4"p>> ',
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
                           let totalSalary = api
                                .column( 0 )
                                .nodes()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal($(b).attr('data-total'));
                                }, 0 );
                            // Total over this page
                           let  pageTotalSalary = api
                                .column( 0, { page: 'current'} )
                                .nodes()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal($(b).attr('data-total'));
                                }, 0 );
                            // Update footer
                            if ( pageTotalSalary === 0 ){
                                 $( api.column( 0 ).footer() )
                                 .html('-');
                            }else{
                                 $( api.column( 0 ).footer() ).html(pageTotalSalary);
                            }
                            
                            $( api.column( 0 ).footer() )
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
                    columns: [0,4]
                },
                language: {
                    url:"$ru"
               }
    }).buttons().container().appendTo('#salary_wrapper .col-md-6:eq(0)');

   table.on("column-reorder", function(e, settings, details){
       let order = table.order();
   });
   

 });


JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

?>