<?php



/* @var $this \yii\web\View */
/* @var $model \core\forms\manage\User\Rate\RateForm */
/* @var $rate  \core\entities\User\Rate*/

$this->title = Yii::t('rate','Update Rate: ') . $rate->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rate','rate'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $rate->name, 'url' => ['view', 'id' => $rate->id]];
$this->params['breadcrumbs'][] = Yii::t('app','Update');
?>
<div class="rate-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>