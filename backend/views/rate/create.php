<?php



/* @var $this \yii\web\View */
/* @var $model \core\forms\manage\User\Rate\RateForm */


$this->title = Yii::t('rate','Create Rate');
$this->params['breadcrumbs'][] = ['label' => Yii::t('rate','rate'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rate-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>