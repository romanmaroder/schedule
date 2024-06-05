<?php



/* @var $this \yii\web\View */
/* @var $model \core\forms\manage\User\Rate\RateForm */
/* @var $rate  \core\entities\User\Rate*/

$this->title = 'Update Rate: ' . $rate->name;
$this->params['breadcrumbs'][] = ['label' => 'Rates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $rate->name, 'url' => ['view', 'id' => $rate->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rate-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>