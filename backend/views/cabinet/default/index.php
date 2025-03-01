<?php

/* @var $this yii\web\View */

/* @var $user \core\entities\User\User */

/* @var $employee \core\entities\User\Employee\Employee */

/* @var $provider \core\entities\Schedule\Event\Event */

use backend\assets\DataTableAsset;
use hail812\adminlte3\assets\PluginAsset;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('cabinet','Cabinet');
$this->params['breadcrumbs'][] = $this->title;
$this->params['user'] = $user;

PluginAsset::register($this)->add(
    ['datatables', 'datatables-bs4', 'datatables-responsive', 'datatables-buttons']
);
DataTableAsset::register($this);
?>

    <div class="active tab-pane" id="events">
        <?= GridView::widget(
            [
                'dataProvider' => $provider,
                //'filterModel' => $searchModel,
                'summary' => false,
                'tableOptions' => [
                    'class' => 'table table-striped table-bordered',
                    'id' => 'event'
                ],
                'emptyText' => false,
                'columns' => [
                    [
                        'attribute' => Yii::t('app', 'start'),
                        'label' => Yii::t('app', 'Created At'),
                        'format' => ['datetime', 'php:d-m-Y']
                    ],
                    [
                        'attribute' => Yii::t('schedule/event', 'Client'),
                        'value' => fn ($model) =>
                             Html::a(
                                Html::encode($model->client->username),
                                ['/user/view', 'id' => $model->client->id]
                            ),
                        'format' => 'raw',
                    ],
                    [
                        'label' => Yii::t('schedule/event','Services'),
                        'value' => fn ($provider) =>
                            implode(', </br>', ArrayHelper::getColumn($provider->services, 'name')),
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'notice',
                        'label' => Yii::t('schedule/event','Notice'),
                        'contentOptions' => [
                            'class'=>'text-center',
                            'style'=>'max-width:150px'
                        ],
                        'format' => 'ntext'
                    ],
                    [
                        'attribute' => 'start',
                        'label' => Yii::t('schedule/event','Time'),
                        'value'=>fn ($model)=>
                             substr($model['start'],10,6) . ' - ' . substr($model['end'],10,6),
                    ],/*
                    [
                        'attribute' => 'start',
                        'format' => ['datetime', 'php: H:i']
                    ],
                    [
                        'attribute' => 'end',
                        'format' => ['datetime', 'php: H:i']
                    ],*/

                ],
            ]
        ); ?>
    </div>


    <!--<div class="cabinet-index">

    <h2>Attach profile</h2>
    <?php /*= yii\authclient\widgets\AuthChoice::widget(
        [
            'baseAuthUrl' => ['cabinet/network/attach'],
        ]
    ); */?>
</div>-->

<?php

$ru = Url::to('@web/js/dataTable/internationalisation/plug-ins_2_1_7_i18n_ru.json');

$js = <<< JS
 $(function () {
 
    $('#event').DataTable({
       paging: true,
       lengthChange: true,
       searching: true,
       ordering: false,
       //"order": [[0, 'desc']],
       info: false,
       autoWidth: false,
       responsive: true,
        bStateSave: true,
        fnStateSave: function (oSettings, oData) {
                localStorage.setItem('DataTables_' + window.location.pathname, JSON.stringify(oData));
                },
                fnStateLoad: function () {
                var data = localStorage.getItem('DataTables_' + window.location.pathname);
                return JSON.parse(data);
                },
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
                    url: '$ru',
                },
    }).buttons().container().appendTo('#event_wrapper .col-md-6:eq(0)');

  });

JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

?>