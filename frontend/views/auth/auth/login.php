<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/** @var \core\forms\auth\LoginForm $model */

$this->title = Yii::t('login','login');
?>
<div class="">
    <?php if (Yii::$app->getSession()->hasFlash('success')): ?>
        <?php
        echo '<p class="text-success text-center"><b>' . Yii::$app->session->getFlash('success') . '</b></p>'; ?>
    <?php
    else: ?>
        <?php echo '<p class="text-danger text-center"><b>' . Yii::$app->session->getFlash('error') . '</b></p>'; ?>
    <?php
    endif; ?>
</div>
<div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg"><?=Yii::t('login','Login to start your session')?></p>

        <?php $form = ActiveForm::begin(['id' => 'login-form']) ?>

        <?= $form->field($model, 'username', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div>',
            'template' => '{beginWrapper}{input}{error}{hint}{endWrapper}',
            'wrapperOptions' => ['class' => 'input-group mb-3']
        ])
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel(Yii::t('user','Username'))]) ?>

        <?= $form->field($model, 'password', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>',
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
            'wrapperOptions' => ['class' => 'input-group mb-3']
        ])
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel(Yii::t('user','Password'))]) ?>

        <div class="row">
            <div class="col-8">
                <?= $form->field($model, 'rememberMe',
                    ['options' =>
                        ['template' => '<div class="icheck-primary">{input}{label}</div>',
                        'labelOptions' => ['class' => ''],
                        'uncheck' => null],
                    ])->checkbox([])->label(Yii::t('login','Remember Me')) ?>
            </div>
            <div class="col-4">
                <?= Html::submitButton(Yii::t('login','Sign In'), ['class' => 'btn btn-primary btn-block','name'=>'submitButton']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

        <!--<div class="social-auth-links text-center mb-3">
            <p>- OR -</p>
            <? /*= yii\authclient\widgets\AuthChoice::widget(
                [
                    'baseAuthUrl' => ['auth/network/auth']
                ]
            ); */ ?>
        </div>-->
        <!-- /.social-auth-links -->

        <p class="mb-1">
            <?= Html::a(Yii::t('login','I forgot my password'), ['auth/reset/request-password-reset']) ?>
        </p>
        <p class="mb-0">
            <?= Html::a(Yii::t('login','Need new verification email?'), ['auth/resend/resend-verification-email']) ?>
        </p>
    </div>
    <!-- /.login-card-body -->
</div>
