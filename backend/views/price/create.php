<?php



/* @var $this \yii\web\View */
/* @var $model \schedule\forms\manage\User\Price\PriceForm */

$this->title = 'Create Price';
$this->params['breadcrumbs'][] = ['label' => 'Price', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="price-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>