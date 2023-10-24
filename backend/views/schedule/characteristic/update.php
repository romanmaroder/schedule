<?php

/* @var $this yii\web\View */
/* @var $characteristic schedule\entities\Schedule\Characteristic */
/* @var $model schedule\forms\manage\Schedule\CharacteristicForm */

$this->title = 'Update Characteristic: ' . $characteristic->name;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $characteristic->name, 'url' => ['view', 'id' => $characteristic->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="characteristic-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>