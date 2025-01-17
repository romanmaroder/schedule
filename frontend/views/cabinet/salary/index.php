<?php
/* @var $this yii\web\View */

/* @var $cart \core\cart\schedule\Cart */

/* @var $dataProvider \yii\data\ArrayDataProvider */

use frontend\assets\DataTableAsset;
use hail812\adminlte3\assets\PluginAsset;
use core\helpers\DiscountHelper;
use kartik\date\DatePicker;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

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
                    <?php
                    $form = ActiveForm::begin(); ?>
                    <div class="col-12">
                        <div class="form-group"><?=
                            DatePicker::widget(
                                [
                                    'name' => 'from_date',
                                    'value' => '',
                                    'type' => DatePicker::TYPE_RANGE,
                                    'name2' => 'to_date',
                                    'value2' => '',
                                    'separator' => 'до',
                                    'removeButton' => true,
                                    'size' => 'sm',
                                    'options' => ['placeholder' => $params['from_date'] ?? ''],
                                    'options2' => ['placeholder' => $params['to_date'] ?? ''],
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'todayHighlight' => true,
                                        'format' => 'yyyy-mm-dd',
                                    ],
                                ]
                            ); ?></div>
                        <div class="form-group">
                            <?= Html::submitButton(
                                Yii::t('app', 'Update'),
                                ['class' => 'btn btn-secondary btn-sm btn-shadow bg-gradient text-shadow']
                            ) ?>
                        </div>
                    </div><?php
                    ActiveForm::end(); ?>
                </div>
                <div class="row">
                    <div class="col"><?php
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
                                'emptyText' => false,
                                'rowOptions' => fn($model) => ['style' => 'background-color:' . $model->getColor()],
                                'columns' => [
                                    [
                                        'attribute' => 'Date',
                                        'label' => Yii::t('cabinet/report', 'Date'),
                                        'headerOptions' => ['class' => ''],
                                        'value' => fn($model) => DATE('Y-m-d', strtotime($model->getDate())),
                                        'contentOptions' => fn($model) => [
                                            'data-total' => $model->getSalary(),
                                            'class' => ['text-center align-middle']
                                        ],
                                        'footer' => $cart->getFullSalary(),
                                        'footerOptions' => ['class' => 'bg-primary bg-gradient text-center '],
                                    ],
                                    [
                                        'attribute' => 'Price',
                                        'label' => Yii::t('cabinet/report', 'Price'),
                                        'headerOptions' => ['class' => 'text-center'],
                                        'value' => fn($model) => $model->getMasterPrice(),
                                        'contentOptions' => [
                                            'class' => ['text-center align-middle']
                                        ],
                                        'format' => 'raw'
                                    ],
                                    [
                                        'attribute' => 'Salary',
                                        'label' => Yii::t('cabinet/report', 'Salary'),
                                        'headerOptions' => ['class' => 'text-center'],
                                        'value' => fn($model) => $model->getSalary(),
                                        'contentOptions' => fn($model) => [
                                            //'data-total' => $model->getSalary(),
                                            'class' => ['text-center align-middle ']
                                        ],
                                        /*'footer' => $cart->getFullSalary(),
                                        'footerOptions'  => ['class' => 'bg-info text-center '],*/
                                    ],
                                    [
                                        'attribute' => 'Discounted price',
                                        'label' => Yii::t('cabinet/report', 'Discounted price'),
                                        'headerOptions' => ['class' => 'text-center'],
                                        'value' => fn($model) => $model->getDiscountedPrice(),
                                        'contentOptions' => [
                                            'class' => ['text-center align-middle']
                                        ]
                                    ],
                                    [
                                        'attribute' => 'Service',
                                        'label' => Yii::t('cabinet/report', 'Service'),
                                        'headerOptions' => ['class' => 'text-center'],
                                        'value' => fn($model) => $model->getServiceList(),
                                        'contentOptions' => [
                                            'class' => ['text-center align-middle']
                                        ],
                                        //'footer' => $cart->getPrice(),
                                        'format' => 'raw'
                                    ],
                                    [
                                        'attribute' => 'Discount',
                                        'label' => Yii::t('cabinet/report', 'Discount'),
                                        'headerOptions' => ['class' => 'text-center'],
                                        'value' => fn($model) => $model->getDiscount(
                                            ) . '%<br>' . DiscountHelper::discountLabel($model->getDiscountFrom()),
                                        'contentOptions' => [
                                            'class' => ['text-center align-middle']
                                        ],
                                        'format' => 'raw'
                                    ],
                                    [
                                        'attribute' => 'username',
                                        'label' => Yii::t('user', 'Username'),
                                        'value' => fn($model) => $model->getClientName(),
                                        'contentOptions' => [
                                            'class' => ['text-center align-middle']
                                        ]
                                    ],
                                ]
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
                dom:'<"row"<"col-12"Q><"col-auto"l>> t <"row"<"col-12 mb-2 mb-md-0 col-md-6"i><"col-12 col-md-6"p>> ',
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