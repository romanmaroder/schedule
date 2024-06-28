<?php


use hail812\adminlte3\assets\PluginAsset;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this \yii\web\View */
/* @var $searchModel \backend\forms\Shop\ReviewSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */



$this->title = 'Review';
$this->params['breadcrumbs'][] = $this->title;


PluginAsset::register($this)->add(
    [
        'datatables',
        'datatables-bs4',
        'datatables-responsive',
        'datatables-buttons',
        'datatables-searchbuilder',
        'datatables-fixedheader',
        'sweetalert2'
    ]
);

?>

<div class="card card-secondary">
    <div class="card-header">
        <!--<h3 class="card-title">
            <?/*=$this->title*/?>
        </h3>-->

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
                'filterModel' => $searchModel,
                'summary' => false,
                'tableOptions' => [
                    'class' => 'table table-striped table-bordered',
                    'id' => 'review'
                ],
                'columns' => [
                    'id',
                    [
                        'attribute' => 'user_id',
                        'value' => function($review){
                            return $review->user->username;
                        }
                    ],
                    [
                        'attribute' => 'product_id',
                        'value' => function($review){
                            return $review->product->name;
                        }
                    ],
                    'created_at:datetime',
                    /*[
                        'attribute' => 'text',
                        'value' => function (Review $model) {
                            return StringHelper::truncate(strip_tags($model->text), 100);
                        },
                    ],*/
                    /*[
                        'attribute' => 'active',
                        'filter' => $searchModel->activeList(),
                        'format' => 'boolean',
                    ],*/
                    ['class' => ActionColumn::class],
                ],
            ]
        ); ?>
    </div>
</div>

<?php
$js = <<< JS
$('#review').DataTable({
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
                    columns: [1,2,3]
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
