<?php

use backend\assets\DataTableAsset;
use core\entities\user\User;
use core\helpers\StatusHelper;
use hail812\adminlte3\assets\PluginAsset;
use kartik\date\DatePicker;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var backend\forms\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('user', 'Users');
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
                        <?= Html::a(
                            Yii::t('app', 'Create'),
                            ['create'],
                            ['class' => 'btn btn-success btn-shadow btn-sm btn-gradient']
                        ) ?>
                    </h3>

                    <div class='card-tools'>
                        <button type='button' class='btn btn-tool' data-card-widget='maximize'><i
                                    class='fas fa-expand'></i>
                        </button>
                        <button type='button' class='btn btn-tool' data-card-widget='collapse'><i
                                    class='fas fa-minus'></i>
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
                                        'id' => 'user'
                                    ],
                                    'emptyText' => false,
                                    'columns' => [
                                        // ['class' => 'yii\grid\SerialColumn'],
                                        //  'id',
                                        [
                                            'attribute' => 'username',
                                            'value' => fn (User $model) =>
                                                 Html::a(Html::encode($model->username), ['view', 'id' => $model->id]),
                                            'format' => 'raw',
                                        ],
                                        [
                                            'attribute' => 'phone',
                                            'value' => fn (User $model) =>
                                                 Html::a(
                                                    Html::encode($model->phone),
                                                    'tel:' . $model->phone,
                                                    ['view', 'id' => $model->id]
                                                ),
                                            'format' => 'raw',
                                        ],
                                        'email:email',
                                        [
                                            'attribute' => 'status',
                                            // 'filter' => UserHelper::statusList(),
                                            'filter' => Html::activeDropDownList(
                                                $searchModel,
                                                'status',
                                                StatusHelper::statusList(),
                                                ['prompt' => 'Select...', 'class' => 'form-control form-control-sm']
                                            ),
                                            'value' => fn (User $model) =>
                                            StatusHelper::statusLabel($model->status),
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
            </div>

        </div>
    </div>
</div>
<?php
$ru = Url::to('@web/js/dataTable/internationalisation/plug-ins_2_1_7_i18n_ru.json');
$js = <<< JS
 $(function () {
 
    $('#user').DataTable({
        bStateSave: true,
        pageLength: 10, 
        paging: true,
        lengthChange: true,
        lengthMenu: [[10, 25, 50, -1], [ 10, 25, 50,"All"]],
        searching: true,
        ordering: false,
        info: false,
        autoWidth: false,
        responsive: true,
        // dom: "<'row'<'col-6 col-md-6 order-3 order-md-1 text-left'B><'col-sm-12 order-md-2 col-md-6 d-flex d-md-block'f>>tp",
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
        language: {
          url:"$ru"
         }
    }).buttons().container().appendTo('#user_wrapper .col-md-6:eq(0)');

  });

JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

?>
