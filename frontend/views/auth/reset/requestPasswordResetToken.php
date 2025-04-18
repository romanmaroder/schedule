<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \core\forms\auth\PasswordResetRequestForm $model */

use core\helpers\tHelper;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = tHelper::translate('user/auth','Request password reset');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-request-password-reset">
    <?php if (Yii::$app->getSession()->hasFlash('success')):?>
        <?php
        echo '<p class="text-success text-center"><b>'.Yii::$app->session->getFlash('success').'</b></p>'; ?>
    <?php
    else: ?>
        <?php  echo '<p class="text-danger text-center"><b>'.Yii::$app->session->getFlash('error').'</b></p>'; ?>
    <?php
    endif; ?>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg"><?= tHelper::translate('user/auth', 'reset-pass')?></p>


            <?php
            $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

            <?= $form->field($model, 'email')->textInput(
                [
                    'autofocus' => true,
                    'placeholder' => $model->getAttributeLabel('email')
                ]
            )->label(false) ?>

            <div class="form-group">
                <?= Html::submitButton(tHelper::translate('user/auth', 'Send'), ['class' => 'btn btn-primary']) ?>
            </div>

            <?php
            ActiveForm::end(); ?>
        </div>
    </div>
</div>
