<?php


/* @var $this \yii\web\View */

/* @var $cart \schedule\cart\Cart */

/* @var $event \yii\data\ArrayDataProvider */

/* @var $expense schedule\forms\manage\Expenses\ */

/* @var $merg */


use hail812\adminlte3\assets\PluginAsset;

$this->title = 'Summary Report';
$this->params['breadcrumbs'][] = ['label' => 'Cabinet', 'url' => ['/cabinet/default/index']];
$this->params['breadcrumbs'][] = $this->title;


PluginAsset::register($this)->add(
    [
        'datatables',
        'datatables-bs4',
        'datatables-responsive',
    ]
);


?>
    <div class="report-summary">

            <div class="container-fluid">
                <div class="row">
                    <div class="col"> <table class='table table-bordered table-striped' id='report'>
                            <thead>
                            <tr>
                                <th class="text-center">Profit</th>
                                <th class="text-center">Expenses</th>
                                <th class="text-left">Total with costs</th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="text-center"><?= $cart->getFullProfit() ?></td>
                                <td class="text-center"><?= $expense ?></td>
                                <td class="text-left"
                                    data-total="<?= $cart->getTotalWithSubtractions($expense); ?>"><?= $cart->getFullProfit() ?>
                                    - <?= $expense ?></td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td></td>
                                <td class="text-right">TOTAL:</td>
                                <td class="text-left"><?= $cart->getTotalWithSubtractions($expense); ?></td>
                                <!-- Задаем количество ячеек по горизонтали для объединения-->
                            </tr>
                            </tfoot>
                        </table></div>
                </div>


            </div>
        </div>
<?php
$js = <<< JS
 $(function () {
   let table= $('#report').DataTable({
                bDestroy: true,
                responsive: true,
                pageLength: 10,
                paging: true,
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
                dom:'<"row"> t <"row"<"col-sm-4"l><"col-sm-4 mb-2"i><"col-sm-4"p>> ',
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
                                .column( 2, { page: 'current'} )
                                .nodes()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal($(b).attr('data-total'));
                                }, 0 );
                            // Update footer
                            if ( pageTotalProfit === 0 ){
                                 $( api.column( 2 ).footer() )
                                 .html('-');
                            }else{
                                 $( api.column( 2 ).footer() ).html(pageTotalProfit);
                            }

                            $( api.column( 2 ).footer() )
                            .html( pageTotalProfit );

                        },
                fnStateSave: function (oSettings, oData) {
                localStorage.setItem('DataTables_' + window.location.pathname, JSON.stringify(oData));
                },
                fnStateLoad: function () {
                var data = localStorage.getItem('DataTables_' + window.location.pathname);
                return JSON.parse(data);
                },
                language: {
                    lengthMenu: 'Show <select class="form-control form-control-sm">'+
                    '<option value="10">10</option>'+
                    '<option value="20">20</option>'+
                    '<option value="50">50</option>'+
                    '<option value="-1">All</option>'+
                    '</select>',
                    paginate: {
                        first: "First",
                        previous: '<i class="fas fa-backward"></i>',
                        last: "Last",
                        next: '<i class="fas fa-forward"></i>'
                    }
                }
    });

   table.on("column-reorder", function(e, settings, details){
       let order = table.order();
   });
   

 });


JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);

?>