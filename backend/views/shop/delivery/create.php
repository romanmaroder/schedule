<?php



/* @var $this \yii\web\View */
/* @var $model \core\forms\manage\Shop\DeliveryMethodForm */

$this->title = Yii::t('shop/delivery','Create Delivery Method');
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop/delivery','Delivery Methods'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="method-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>