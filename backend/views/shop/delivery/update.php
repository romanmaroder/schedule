<?php



/* @var $this \yii\web\View */
/* @var $model \core\forms\manage\Shop\DeliveryMethodForm */
/* @var $method \core\entities\Shop\DeliveryMethod */

$this->title = Yii::t('shop/delivery','Update Delivery Method: ') . $method->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop/delivery','Delivery Methods'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $method->name, 'url' => ['view', 'id' => $method->id]];
$this->params['breadcrumbs'][] = Yii::t('app','Update');
?>
<div class="method-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>