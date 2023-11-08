<?php

/** @var yii\web\View$this  */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var \schedule\forms\auth\ResendVerificationEmailForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Resend verification email';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-resend-verification-email">
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">
                Please fill out your email. A verification email will be sent there.</p>

                    <?php
                    $form = ActiveForm::begin(['id' => 'resend-verification-email-form']); ?>

                    <?= $form->field($model, 'email')->textInput(
                        [
                            'autofocus' => true,
                            'placeholder' => $model->getAttributeLabel('email')
                        ]
                    )->label(false) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Send', ['class' => 'btn btn-primary']) ?>
                    </div>

                    <?php
                    ActiveForm::end(); ?>

        </div>
    </div>
</div>
