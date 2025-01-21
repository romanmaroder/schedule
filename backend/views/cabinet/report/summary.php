<?php


/* @var $this \yii\web\View */

/* @var $cart \core\cart\schedule\CartWithParams */

/* @var $amountOfExpenses core\forms\manage\Expenses\ */

/* @var $params */

/* @var $merg */

/* @var $dataProvider \yii\data\ArrayDataProvider */


use backend\assets\DataTableAsset;
use core\entities\Expenses\Expenses\Expenses;
use core\helpers\PriceHelper;
use hail812\adminlte3\assets\PluginAsset;
use kartik\date\DatePicker;
use yii\bootstrap4\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('cabinet/report', 'Summary Report');
$this->params['breadcrumbs'][] = ['label' => Yii::t('cabinet', 'Cabinet'), 'url' => ['/cabinet/default/index']];
$this->params['breadcrumbs'][] = $this->title;


PluginAsset::register($this)->add(
    [
        'datatables',
        'datatables-bs4',
        'datatables-responsive',
    ]
);
DataTableAsset::register($this);

?>
    <div class="report-summary">

        <div class="container-fluid">
            <div class="row">
                <?php
                $form = ActiveForm::begin(); ?>
                <div class="col-12">
                    <div class="form-group"><?=
                         DatePicker::widget(
                            [
                                'name' => 'from_date',
                                'value' =>  '' ,
                                'type' => DatePicker::TYPE_RANGE,
                                'name2' => 'to_date',
                                'value2' => '',
                                'separator' => 'до',
                                'removeButton'=>true,
                                'options' => ['placeholder' => $params['from_date'] ?? ''],
                                'options2' => ['placeholder' => $params['to_date'] ?? ''],
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'todayHighlight' => true,
                                    'format' => 'yyyy-mm-dd',
                                ]
                            ]
                        ); ?></div>
                    <div class="form-group">
                        <?= Html::submitButton(
                            Yii::t('app', 'Update'),
                            ['class' => 'btn btn-secondary btn-sm btn-shadow bg-gradient text-shadow']
                        ) ?>
                    </div>
                </div><?php
                ActiveForm::end(); ?>
            </div>
            <div class="row">
                <div class="col"> <table class='table table-bordered table-striped' id='report'>
                            <thead>
                            <tr>
                                <th class="text-center"><?=Yii::t('cabinet/report','Date') ?></th>
                                <th class="text-center"><?=Yii::t('cabinet/report','Profit') ?></th>
                                <th class="text-center"><?=Yii::t('cabinet/report','Expenses') ?></th>
                                <th class="text-right"><?=Yii::t('cabinet/report','Total with costs') ?></th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="text-center"><?= Yii::$app->formatter->asDate($params['from_date'],'medium') . ' - ' . Yii::$app->formatter->asDate($params['to_date'],'medium') ?></td>
                                <td class="text-center"><?= $cart->getFullProfitOnlyFromServicesPaidFor()  ?></td>
                                <td class="text-center"><?= $amountOfExpenses ?? '0'  ?></td>
                                <td class="text-right"
                                    data-total="<?= $cart->getTotalWithSubtractions($amountOfExpenses);  ?>"><?= $cart->getFullProfitOnlyFromServicesPaidFor()  ?>
                                    - <?= $amountOfExpenses ?? '0' ?> </td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td class="text-center"><?=Yii::t('cabinet/report','TOTAL') ?>:</td>
                                <td class="text-right bg-primary" data-total="<?= $cart->getTotalWithSubtractions($amountOfExpenses);  ?>"><?= $cart->getTotalWithSubtractions($amountOfExpenses);  ?></td>
                            </tr>
                            </tfoot>
                        </table></div>
            </div>

        </div>
    </div>
<?php

$ru = Url::to('@web/js/dataTable/internationalisation/plug-ins_2_1_7_i18n_ru.json');

$js = <<< JS
 $(function () {
   let table= $('#report').DataTable({
                responsive: true,
                paging: false,
                searching: true,
                ordering: false,
                info: true,
                autoWidth: false,
                bStateSave: true,
                dom:'t <"row"<"col-sm-4"l><"col-sm-4 mb-2"i><"col-sm-4"p>> ',
                footerCallback: function ( row, data, start, end, display ) {
                            var api = this.api();
                            // Remove the formatting to get integer data for summation
                            var intVal = function ( i ) {
                                return typeof i === 'string' ?
                                    i.replace(/[\$,]/g, '')*1 :
                                    typeof i === 'number' ?
                                        i : 0;
                            };
                            
                            // Total over this page
                           let pageTotalProfit = api
                                .column( 3, { page: 'current'} )
                                .nodes()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal($(b).attr('data-total'));
                                }, 0 );
                            // Update footer
                            if ( pageTotalProfit === 0 ){
                                 $( api.column( 3 ).footer() )
                                 .html('-');
                            }else{
                                 $( api.column( 3 ).footer() ).html(pageTotalProfit);
                            }

                            $( api.column( 3 ).footer() )
                            .html( pageTotalProfit );

                        },
                        language: {
                    url: '$ru',
                },
    }); 
 });


JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

?>