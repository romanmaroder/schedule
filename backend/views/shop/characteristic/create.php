<?php

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\Shop\CharacteristicForm */

$this->title = Yii::t('shop/characteristic','Create Characteristic');
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop/characteristic','Characteristic'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="characteristic-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>