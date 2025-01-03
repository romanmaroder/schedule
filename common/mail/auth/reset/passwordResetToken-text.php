<?php

/** @var yii\web\View $this */
/** @var core\entities\User\User $user */

use core\helpers\tHelper;

$resetLink = Yii::$app->get('frontendUrlManager')->createAbsoluteUrl(['auth/reset/reset-password', 'token' => $user->password_reset_token]);
?>
<?= tHelper::translate('user/auth', 'greeting') ?> <?= $user->username ?>,

<?= tHelper::translate('user/auth', 'follow') ?>

<?= $resetLink ?>
