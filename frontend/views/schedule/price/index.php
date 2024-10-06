<?php

/* @var $this yii\web\View */
/* @var $category \core\entities\Schedule\Service\Category*/
/* @var $dataProvider yii\data\DataProviderInterface */
/* @var $user \core\entities\User\User */

$this->title = Yii::t('price','Price');
$this->params['breadcrumbs'][] = $this->title;
?>

        <?= $this->render('_service', [
    'dataProvider' => $dataProvider,
    'user' => $user,
    'category' => $category
]) ?>
