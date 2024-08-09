<?php


/* @var $this \yii\web\View */

/* @var $searchModel \backend\forms\EmployeeSearch */

/* @var $dataProvider \yii\data\ActiveDataProvider */


use backend\widgets\grid\RoleColumn;
use core\helpers\EmployeeHelper;
use hail812\adminlte3\assets\PluginAsset;
use core\entities\User\Employee\Employee;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

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
                'summary' => false,
                'tableOptions' => [
                    'class' => 'table table-striped table-bordered',
                    'id' => 'employee'
                ],
                'columns' => [
                    //['class' => 'yii\grid\SerialColumn'],

                    //'id',
                    //'user_id',
                    [
                        'attribute' => 'first_name',
                        'value' => function (Employee $model) {
                            return Html::a(Html::encode($model->getFullName()), ['/employee/view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'role',
                        'class' => RoleColumn::class,
                        //'filter' => $searchModel->rolesList(),
                        'contentOptions' => [
                            'class'=>'text-center'
                        ],
                        'headerOptions' => ['class' => 'text-center'],
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
                            return EmployeeHelper::statusLabel($model->status);
                        },
                        'contentOptions' => [
                                'class'=>'text-center'
                        ],
                        'headerOptions' => ['class' => 'text-center'],
                        'format' => 'raw'
                    ],
                    [
                        'class' => ActionColumn::class,
                        'urlCreator' => function ($action, Employee $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }
                    ],
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
        pageLength: -1, 
        paging: true,
        lengthChange: true,
        lengthMenu: [[10, 25, 50, -1], [ 10, 25, 50,"All"]],
        searching: true,
        ordering: true,
        info: false,
        autoWidth: false,
        responsive: true,
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
          "search":"Search"
         }
    }).buttons().container().appendTo('#event_wrapper .col-md-6:eq(0)');

  });

JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

?>