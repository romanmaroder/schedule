<?php


/* @var $this \yii\web\View */

/* @var $cash  \schedule\entities\Schedule\Event\Event */
/* @var $card  \schedule\entities\Schedule\Event\Event */

/* @var $cart  \schedule\cart\Cart */

use hail812\adminlte3\assets\PluginAsset;

$this->title = 'Payments';
$this->params['breadcrumbs'][] = ['label' => 'Cabinet', 'url' => ['/cabinet/default/index']];
$this->params['breadcrumbs'][] = $this->title;

PluginAsset::register($this)->add(
    [
        'datatables',
        'datatables-bs4',
        'datatables-responsive',
        'datatables-buttons',
        'datatables-colreorder',
        'datatables-searchbuilder',
        'datatables-fixedheader',
    ]
);
?>

    <div class="payments">

        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <table class='table table-bordered table-striped' id='payment'>
                        <thead>
                        <tr>
                            <th class="text-left">Date</th>
                            <th class="text-center">Card</th>
                            <th class="text-center">Cash</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($cart->getItems() as $item) : ?>
                            <tr>
                                <td class="text-left"><?= DATE('Y-m-d', strtotime($item->getDate())) ?></td>
                                <td class="text-center" data-total="<?= $item->getCard() ?>"><?= $item->getCard() ?></td>
                                <td class="text-center" data-total="<?= $item->getCash() ?>"><?= $item->getCash() ?></td>
                            </tr>
                        <?php
                        endforeach; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td class="text-right">TOTAL:</td>
                            <td class="text-center"> <?= $card ?></td>
                            <td class="text-center"><?= $cash ?></td>
                            <!-- Задаем количество ячеек по горизонтали для объединения-->
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>


<?php
$js = <<< JS
$(function () {
let table= $('#payment').DataTable({
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
                dom:'<"row"<"col-12"Q><"col-12"B>> t <"row"<"col"l><"col"i><"col"p>> ',
                footerCallback: function ( row, data, start, end, display ) {
                            var api = this.api();
                            // Remove the formatting to get integer data for summation
                            var intVal = function ( i ) {
                                return typeof i === 'string' ?
                                    i.replace(/[\$,]/g, '')*1 :
                                    typeof i === 'number' ?
                                        i : 0;
                            };
                         
                            // Total over all pages
                           let totalCard = api
                                .column( 1 )
                                .nodes()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal($(b).attr('data-total'));
                                }, 0 );
                            // Total over this page
                           let pageTotalCard = api
                                .column( 1, { page: 'current'} )
                                .nodes()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal($(b).attr('data-total'));
                                }, 0 );
                            // Update footer
                            if ( pageTotalCard === 0 ){
                                 $( api.column( 1 ).footer() )
                                 .html('-');
                            }else{
                                 $( api.column( 1 ).footer() ).html(pageTotalCard);
                            }
                            
                            
                           let totalCash = api
                                .column( 2 )
                                .nodes()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal($(b).attr('data-total'));
                                }, 0 );
                            // Total over this page
                           let pageTotalCash = api
                                .column( 2, { page: 'current'} )
                                .nodes()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal($(b).attr('data-total'));
                                }, 0 );
                            // Update footer
                            if ( pageTotalCash === 0 ){
                                 $( api.column( 2 ).footer() )
                                 .html('-');
                            }else{
                                 $( api.column( 2 ).footer() ).html(pageTotalCash);
                            }
                            
                            
                            $( api.column( 0 ).footer() )
                            .html( pageTotalCard + pageTotalCash);

                        },
                fnStateSave: function (oSettings, oData) {
                localStorage.setItem('DataTables_' + window.location.pathname, JSON.stringify(oData));
                },
                fnStateLoad: function () {
                var data = localStorage.getItem('DataTables_' + window.location.pathname);
                return JSON.parse(data);
                },
                searchBuilder: {
                    columns: [0,1,2]
                },
               buttons: [
                {
                    extend: 'copyHtml5',
                    //title:'111111',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'csvHtml5',
                    //title:'22222',
                    exportOptions: {
                        columns: [0,1,2,':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    // title:'33333',
                    exportOptions: {
                        columns: [':visible']
                    }
                },
                {
                    extend: 'pdfHtml5',
                    //title:'44444',
                    exportOptions: {
                        columns: [0,1,2,':visible']
                    }
                },
                'colvis'
            ],
                
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
    }).buttons().container().appendTo('#report_wrapper .col-md-6:eq(0)');

   /*table.on("column-reorder", function(e, settings, details){
       let order = table.order();
   });*/
   

 });


JS;


$this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);