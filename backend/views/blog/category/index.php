<?php

use backend\assets\DataTableAsset;
use core\entities\Blog\Category;
use hail812\adminlte3\assets\PluginAsset;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\Blog\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('blog/category','Categories');
$this->params['breadcrumbs'][] = $this->title;

PluginAsset::register($this)->add(['datatables',
                                      'datatables-bs4',
                                      'datatables-responsive',
                                      'datatables-buttons',
                                      'datatables-searchbuilder',
                                      'datatables-fixedheader',
                                      'sweetalert2']);
DataTableAsset::register($this);
?>
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <?= Html::a(
                                Yii::t('app','Create'),
                                ['create'],
                                ['class' => 'btn btn-success btn-sm btn-shadow bg-gradient text-shadow']
                            ) ?>
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
                                // 'filterModel' => $searchModel,
                                'summary' => false,
                                'tableOptions' => [
                                    'class' => 'table table-striped table-bordered',
                                    'id' => 'category'
                                ],
                                'emptyText' => false,
                                'columns' => [
                                    'sort',
                                    [
                                        'attribute' => 'name',
                                        'value' => fn (Category $model) =>
                                             Html::a(Html::encode($model->name), ['view', 'id' => $model->id]),
                                        'format' => 'raw',
                                    ],
                                    'slug',
                                    'title',
                                    //['class' => ActionColumn::class],
                                ],
                            ]
                        ); ?>
                    </div>
                    <div class="card-footer">
                        <!--Footer-->
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
$ru = Url::to('@web/js/dataTable/internationalisation/plug-ins_2_1_7_i18n_ru.json');
$js = <<< JS
$('#category').DataTable({
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
                dom:'<"row"<"col-12 btn-sm"Q>> t <"row"<"col-4"l><"col-4"i><"col-4"p>> ',
                fnStateSave: function (oSettings, oData) {
                localStorage.setItem('DataTables_' + window.location.pathname, JSON.stringify(oData));
                },
                fnStateLoad: function () {
                var data = localStorage.getItem('DataTables_' + window.location.pathname);
                return JSON.parse(data);
                },
                searchBuilder: {
                    columns: [1,2]
                },
                language: {
                    url:"$ru"
                }
    }).buttons().container().appendTo('#category_wrapper .col-md-6:eq(0)');



JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

?>