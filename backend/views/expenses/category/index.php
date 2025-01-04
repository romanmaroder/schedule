<?php

/* @var $this \yii\web\View */
/* @var $searchModel \backend\forms\Expenses\CategorySearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */

use backend\assets\DataTableAsset;
use core\entities\Expenses\Category;
use hail812\adminlte3\assets\PluginAsset;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('expenses/category','Categories expenses');
$this->params['breadcrumbs'][] = $this->title;

PluginAsset::register($this)->add(
    ['datatables', 'datatables-bs4', 'datatables-responsive', 'datatables-buttons']
);
DataTableAsset::register($this);
?>
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">
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
                                    'tableOptions' => [
                                        'class' => 'table table-striped table-bordered',
                                        'id' => 'expenses'
                                    ],
                                    'emptyText' => false,
                                    'columns' => [
                                        'id',
                                        [
                                            'attribute' => 'name',
                                            'value' => fn (Category $model) => ($model->depth > 1 ? str_repeat(
                                                    '&nbsp;&nbsp;&nbsp;',
                                                    $model->depth - 1
                                                ) . ' ' : '<i class="fas fa-home fa-xs"></i>&nbsp;&nbsp;') . Html::a(Html::encode($model->name), ['view', 'id' => $model->id]),
                                            'format' => 'raw',
                                        ],
                                        [
                                            'value' => fn (Category $model) =>

                                                    Html::a('<i class="fas fa-arrow-up"></i>', ['move-up', 'id' => $model->id]) .
                                                    Html::a('<i class="fas fa-arrow-down"></i>', ['move-down', 'id' => $model->id]),
                                            'format' => 'raw',
                                            'contentOptions' => ['style' => 'text-align: center'],
                                        ],
                                        'slug',
                                        'title',
                                        //['class' => ActionColumn::class],
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
 
    $('#expenses').DataTable({
       bStateSave:true,
       pageLength: 20, 
       paging: true,
       lengthChange: false,
       searching: true,
       ordering: false,
       info: false,
       autoWidth: false,
       responsive: true,
        language:{url:"$ru"}
    }).buttons().container().appendTo('#expenses_wrapper .col-md-6:eq(0)');

  });

JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

