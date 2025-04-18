<?php


/* @var $this \yii\web\View */

/* @var $searchModel \backend\forms\Schedule\EducationSearch */

/* @var $dataProvider \yii\data\ActiveDataProvider */

use backend\assets\DataTableAsset;
use hail812\adminlte3\assets\PluginAsset;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;


$this->title = Yii::t('schedule/education', 'Education');
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
                <div class='card-header'>
                    <h3 class='card-title'>
                        <?= Html::a(
                            Yii::t('app', 'Create'),
                            ['create'],
                            ['class' => 'btn btn-success btn-sm btn-shadow btn-gradient']
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
                            'tableOptions' => [
                                'class' => 'table table-striped table-bordered',
                                'id' => 'education'
                            ],
                            'emptyText' => false,
                            'columns' => [

                                'id',
                                [
                                    'attribute' => 'teacher_id',
                                    'value' => fn($model) => Html::a(
                                        Html::encode($model->teacher->username),
                                        ['view', 'id' => $model->id]
                                    ),
                                    'format' => 'raw',
                                ],
                                [
                                    'attribute' => 'student_ids',
                                    'value' => fn($model) => implode(
                                        '/ ',
                                        ArrayHelper::getColumn($model->students, fn($student) => Html::a(
                                                Html::encode($student->username),
                                                ['/user/view', 'id' => $student->id]
                                            ) . PHP_EOL)
                                    ),
                                    'format' => 'raw',
                                    'contentOptions' => ['class' => 'text-break'],
                                ],
                                [
                                    'attribute' => 'title',
                                    'format' => 'ntext'
                                ],
                                [
                                    'attribute' => 'start',
                                    'format' => ['datetime', 'php:d.m.Y / H:i:s']
                                ],
                                [
                                    'attribute' => 'end',
                                    'format' => ['datetime', 'php:d.m.Y / H:i:s']
                                ],


                            ],
                        ]
                    ); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$ru = Url::to('@web/js/dataTable/internationalisation/plug-ins_2_1_7_i18n_ru.json');
$js = <<< JS
 $(function () {
 
    $('#education').DataTable({
    bStateSave:true,
       paging: false,
       lengthChange: false,
       searching: true,
       ordering: false,
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
        language: {
          url:"$ru"
         }
    }).buttons().container().appendTo('#education_wrapper .col-md-6:eq(0)');

  });

JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

?>
