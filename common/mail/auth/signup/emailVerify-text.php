<?php

/** @var yii\web\View $this */
/** @var core\entities\User\User $user */

use core\helpers\tHelper;

$verifyLink = Yii::$app->get('frontendUrlManager')->createAbsoluteUrl(['auth/signup/verify-email', 'token' => $user->verification_token]);
?>
<?= tHelper::translate('user/auth', 'greeting') ?> <?= $user->username ?>,

<?= tHelper::translate('user/auth', 'follow-email') ?>

<?= $verifyLink ?>
