<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Cabinet';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cabinet-index">

    <p>Hello! <?= Yii::$app->user->identity->username?>.</p>

    <h2>Attach profile</h2>
    <?= yii\authclient\widgets\AuthChoice::widget([
        'baseAuthUrl' => ['cabinet/network/attach'],
    ]); ?>
</div>