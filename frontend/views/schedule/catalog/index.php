<?php

/* @var $this yii\web\View */
/* @var $category schedule\entities\Schedule\Category */
/* @var $dataProvider yii\data\DataProviderInterface */
/* @var $user \schedule\entities\User\User */

$this->title = 'Category';
$this->params['breadcrumbs'][] = $this->title;
?>

        <?= $this->render('_service', [
    'dataProvider' => $dataProvider,
    'user' => $user,
    'category' => $category
]) ?>
