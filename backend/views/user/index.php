<?php

use hail812\adminlte3\assets\PluginAsset;
use kartik\date\DatePicker;
use schedule\entities\user\User;
use schedule\helpers\UserHelper;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\forms\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;

PluginAsset::register($this)->add(
    ['datatables', 'datatables-bs4', 'datatables-responsive', 'datatables-buttons']
);
?>

<div class="card card-secondary">
    <div class="card-header">
        <h3 class="card-title">
            <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success btn-shadow']) ?>
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
                    'id' => 'user'
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                     'id',
                    [
                        'attribute' => 'username',
                        'value' => function (User $model) {
                            return Html::a(Html::encode($model->username), ['view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'phone',
                        'value' => function (User $model) {
                            return Html::a(
                                Html::encode($model->phone),
                                'tel:' . $model->phone,
                                ['view', 'id' => $model->id]
                            );
                        },
                        'format' => 'raw',
                    ],
                    'email:email',
                    [
                        'attribute' => 'status',
                        // 'filter' => UserHelper::statusList(),
                        'filter' => Html::activeDropDownList(
                            $searchModel,
                            'status',
                            UserHelper::statusList(),
                            ['prompt' => 'Select...', 'class' => 'form-control form-control-sm']
                        ),
                        'value' => function (User $model) {
                            return UserHelper::statusLabel($model->status);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'created_at',
                        'filter' => DatePicker::widget(
                            [
                                'model' => $searchModel,
                                'attribute' => 'date_from',
                                'attribute2' => 'date_to',
                                'type' => DatePicker::TYPE_RANGE,
                                'separator' => '-',
                                'pluginOptions' => [
                                    'todayHighlight' => true,
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd',
                                ],
                            ]),
                        'format' => 'datetime',
                    ],
                    /*[
                        'class' => ActionColumn::class,
                        'urlCreator' => function ($action, User $model, $key, $index, $column) {
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
 
    $('#user').DataTable({
    
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
         },
    }).buttons().container().appendTo('#event_wrapper .col-md-6:eq(0)');

  });

JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

?>
