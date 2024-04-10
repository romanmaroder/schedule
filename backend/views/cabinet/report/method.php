<?php


/* @var $this \yii\web\View */

/* @var $cash  \schedule\entities\Schedule\Event\Event */
/* @var $card  \schedule\entities\Schedule\Event\Event */
/* @var $cart  \schedule\cart\Cart */

$this->title = 'Payments';
$this->params['breadcrumbs'][] = ['label' => 'Cabinet', 'url' => ['/cabinet/default/index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="payments">

    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <table class='table table-bordered table-striped' id='report'>
                    <thead>
                    <tr>
                        <th class="text-center">Card</th>
                        <th class="text-center">Cash</th>

                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="text-center"><?= $card ?></td>
                        <td class="text-center"><?= $cash ?></td>
                    </tr>
                    </tbody>

                </table>
            </div>
        </div>


    </div>
</div>
