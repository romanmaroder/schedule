<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \schedule\forms\auth\ResetPasswordForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Reset password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset-password">
    <div class="card">
        <div class="card-body login-card-body">

            <p>Please choose your new password:</p>

            <?php
            $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

            <?= $form->field($model, 'password')->passwordInput(
                [
                    'autofocus' => true,
                    'placeholder' => $model->getAttributeLabel('password')
                ]
            ) ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php
            ActiveForm::end(); ?>

        </div>
    </div>
</div>

