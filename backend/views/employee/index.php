<?php


/* @var $this \yii\web\View */

/* @var $searchModel \backend\forms\EmployeeSearch */

/* @var $dataProvider \yii\data\ActiveDataProvider */


use hail812\adminlte3\assets\PluginAsset;
use schedule\entities\User\Employee\Employee;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Employee';
$this->params['breadcrumbs'][] = $this->title;

PluginAsset::register($this)->add(
    ['datatables', 'datatables-bs4', 'datatables-responsive', 'datatables-buttons']
);
?>

<div class="card card-secondary">
    <div class="card-header">
        <span class="card-title mb-2 mr-2 mb-md-0 ">
                <span class=""><?= Html::a('Create Employee', ['create'], ['class' => 'btn btn-success btn-shadow btn-sm btn-gradient']) ?></span>
        </span>
        <span class="card-title ">
                <span class=""> <?= Html::a('Create Existing Employee', ['existing-user'], ['class' => 'btn btn-success btn-shadow btn-sm btn-gradient']) ?></span>
        </span>

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
                    'id' => 'employee'
                ],
                'columns' => [
                    //['class' => 'yii\grid\SerialColumn'],

                    //'id',
                    //'user_id',
                    [
                        'attribute' => 'username',
                        'value' => function (Employee $model) {
                            return Html::a(Html::encode($model->user->username), ['/employee/view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                    ],
                    /*[
                        'attribute' => 'first_name',
                        'value' => function (Employee $model) {
                            return Html::a(Html::encode($model->first_name), ['view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'last_name',
                        'value' => function (Employee $model) {
                            return Html::a(Html::encode($model->last_name), ['view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                    ],*/
                    [
                        'attribute' => 'phone',
                        'value' => function (Employee $model) {
                            return Html::a(Html::encode($model->phone), 'tel:' . $model->phone, ['view', 'id' => $model->id]);
                        },
                        'contentOptions' => [
                            'class'=>'text-center'
                        ],
                        'headerOptions' => ['class' => 'text-center'],
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'color',
                        'value' => function (Employee $model) {
                            return Html::tag(
                                'div',
                                '',
                                ['style' => 'width:20px;height:20px;margin:0 auto;background-color:' . $model->color]
                            );
                        },
                        'headerOptions' => ['class' => 'text-center'],
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'status',
                        'value' => function ($model) {
                            return \schedule\helpers\EmployeeHelper::statusLabel($model->status);
                        },
                        'contentOptions' => [
                                'class'=>'text-center'
                        ],
                        'headerOptions' => ['class' => 'text-center'],
                        'format' => 'raw'
                    ]
                    /*[
                        'class' => ActionColumn::class,
                        'urlCreator' => function ($action, Employee $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }
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

<?php
$js = <<< JS
 $(function () {
 
    $('#employee').DataTable({
    
       "paging": false,
       "lengthChange": false,
       "searching": true,
       "ordering": true,
       "info": false,
       "autoWidth": false,
       "responsive": true,
        // "dom": "<'row'<'col-6 col-md-6 order-3 order-md-1 text-left'B><'col-sm-12 order-md-2 col-md-6 d-flex d-md-block'f>>tp",
      // "buttons": [
      //   {
		// 		"text": "Добавить категорию",
		// 		"className":"btn btn-success",
		// 		"tag":"a",
		// 		"attr":{
		// 		//"href":create
		// 		},
		// 		/*"action": function ( e, dt, node, config ) {
		// 		  $(location).attr('href',config.attr.href);
		// 		}*/
      //   }
      //   ],
        "language": {
          "search":"Поиск"
         }
    }).buttons().container().appendTo('#event_wrapper .col-md-6:eq(0)');

  });

JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

?>