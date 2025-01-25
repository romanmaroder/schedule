<?php

use backend\assets\DataTableAsset;
use hail812\adminlte3\assets\PluginAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model \core\entities\Schedule\Event\Event */

PluginAsset::register($this)->add(
    [
        'datatables',
        'datatables-bs4',
        'datatables-responsive',
        'datatables-searchbuilder'
    ]
);
DataTableAsset::register($this);


$this->title =Yii::t('app','History') . ': ' . $model[0]->client->username;
$this->params['breadcrumbs'][] = $model[0]->client->username;
?>
    <div class="history-view container-fluid">

        <table class="table table-bordered" id="history">
            <thead>
            <tr>
                <th class="text-center"><?=Yii::t('cabinet/report','Date')?></th>
                <th class="text-center"><?=Yii::t('cabinet/report','Master')?></th>
                <th class="text-center"><?=Yii::t('cabinet/report','Service')?></th>
                <th class="text-center"><?=Yii::t('cabinet/report','Price')?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($model as $key=>$value):?>
                <tr>
                    <td><?=Date('Y-m-d',strtotime($value->start))?></td>
                    <td><?=$value->master->username?></td>
                    <td><?=implode(',</br> ', ArrayHelper::getColumn($value->services, 'name'))?></td>
                    <td class="text-center" data-total="<?=$value->amount?>"><?=$value->amount?></td>
                </tr>
            <?php endforeach;?>
            </tbody>
            <tfoot><tr>
                <th></th>
                <th></th>
                <th></th>
                <th class="text-center bg-info"></th></tr></tfoot>
        </table>

    </div>

<?php
$ru = Url::to('@web/js/dataTable/internationalisation/plug-ins_2_1_7_i18n_ru.json');
$js = <<< JS
 $(function () {
 
    $('#history').DataTable({
        pageLength: 10, 
        paging: true,
        lengthChange: true,
        lengthMenu: [[10, 25, 50, -1], [ 10, 25, 50,"All"]],
        searching: true,
        ordering: true,
        info: true,
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
        dom:'<"row"<"col-12 btn-sm"Q><"col-auto"l>> t <"row"<"col-12 mb-2 mb-md-0 col-md-6"i><"col-12 col-md-6"p>> ',
        footerCallback: function ( row, data, start, end, display ) {
                var api = this.api();
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                return typeof i === 'string' ?
                i.replace(/[\$,]/g, '')*1 :
                typeof i === 'number' ?
                i : 0;
                };
                
                 let totalCash = api
                                .column( 3)
                                .nodes()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal($(b).attr('data-total'));
                                }, 0 );
                            // Total over this page
                           let pageTotalCash = api
                                .column( 3, { page: 'current'} )
                                .nodes()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal($(b).attr('data-total'));
                                }, 0 );
                            // Update footer
                            if ( pageTotalCash === 0 ){
                                 $( api.column( 3).footer() )
                                 .html('-');
                            }else{
                                 $( api.column( 3 ).footer() ).html(pageTotalCash);
                            }
                },
        language: {
          url:"$ru"
         },
         searchBuilder: {
                    columns: [0,1,2]
                }
    });
  });

JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

?>