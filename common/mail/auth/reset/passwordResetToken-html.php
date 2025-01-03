<?php

use core\helpers\tHelper;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var core\entities\User\User $user */

$resetLink = Yii::$app->get('frontendUrlManager')->createAbsoluteUrl(
    ['auth/reset/reset-password', 'token' => $user->password_reset_token]
);
?>
<div class="password-reset">
    <p><?= tHelper::translate('user/auth', 'greeting') ?><?= Html::encode($user->username) ?>,</p>

    <p><?= tHelper::translate('user/auth', 'follow') ?></p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
