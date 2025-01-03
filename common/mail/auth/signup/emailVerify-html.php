<?php

use core\helpers\tHelper;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var core\entities\User\User $user */

$verifyLink = Yii::$app->get('frontendUrlManager')
    ->createAbsoluteUrl(['auth/signup/verify-email', 'token' => $user->verification_token]);

?>
<div class="verify-email">
    <p><?= tHelper::translate('user/auth', 'greeting') ?> <?= Html::encode($user->username) ?>,</p>

    <p><?= tHelper::translate('user/auth', 'follow-email') ?></p>

    <p><?= Html::a(Html::encode($verifyLink), $verifyLink) ?></p>
</div>
