<?php

/* @var $this yii\web\View */
/* @var $characteristic \core\entities\CommonUses\Characteristic */
/* @var $model \core\forms\manage\Shop\CharacteristicForm */

$this->title = Yii::t('shop/characteristic','Update Characteristic: ') . $characteristic->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop/characteristic','Characteristic'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $characteristic->name, 'url' => ['view', 'id' => $characteristic->id]];
$this->params['breadcrumbs'][] = Yii::t('app','Update');
?>
<div class="characteristic-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>