<?php

/** @var yii\web\View $this */
/** @var schedule\entities\User\User $user */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/signup/verify-email', 'token' => $user->verification_token]);
?>
Hello <?= $user->username ?>,

Follow the link below to verify your email:

<?= $verifyLink ?>
