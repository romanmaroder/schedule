<?php


/* @var $this \yii\web\View */

/* @var $searchModel \backend\forms\PageSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */

/* @var $searchModel backend\forms\PageSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use core\entities\Page;
use hail812\adminlte3\assets\PluginAsset;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Pages';
$this->params['breadcrumbs'][] = $this->title;

PluginAsset::register($this)->add(['datatables',
                                      'datatables-bs4',
                                      'datatables-responsive',
                                      'datatables-buttons',
                                      'datatables-searchbuilder',
                                      'datatables-fixedheader',
                                      'sweetalert2']);

?>


<div class="card card-secondary">
    <div class="card-header">
        <h3 class="card-title">
            <?= Html::a('Create Page', ['create'], ['class' => 'btn btn-success btn-sm btn-gradient btn-shadow']) ?>
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
                    'id' => 'pages'
                ],
                'columns' => [
                    [
                        'attribute' => 'title',
                        'value' => function (Page $model) {
                            $indent = ($model->depth > 1 ? str_repeat(
                                    '&nbsp;&nbsp;',
                                    $model->depth - 1
                                ) . ' ' : '');
                            return $indent . Html::a(Html::encode($model->title), ['view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'value' => function (Page $model) {
                            return
                                Html::a(
                                    '<i class="fas fa-arrow-up"></i>',
                                    ['move-up', 'id' => $model->id]
                                ) .
                                Html::a(
                                    '<i class="fas fa-arrow-down"></i>',
                                    ['move-down', 'id' => $model->id]
                                );
                        },
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'text-align: center'],
                    ],
                    'slug',
                    //'title',
                    ['class' => ActionColumn::class],
                ],
            ]
        ); ?>
    </div>
</div>

<?php
$js = <<< JS
$('#pages').DataTable({
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
                dom:'<"row"<"col-12"Q>> t <"row"<"col-4"l><"col-4"i><"col-4"p>> ',
                fnStateSave: function (oSettings, oData) {
                localStorage.setItem('DataTables_' + window.location.pathname, JSON.stringify(oData));
                },
                fnStateLoad: function () {
                var data = localStorage.getItem('DataTables_' + window.location.pathname);
                return JSON.parse(data);
                },
                searchBuilder: {
                    columns: [0,2]
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
    }).buttons().container().appendTo('#review_wrapper .col-md-6:eq(0)');



JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

?>