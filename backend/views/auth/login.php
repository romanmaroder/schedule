<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/* @var $model \core\forms\auth\LoginForm */
?>
<div class="">
    <?php
    if (Yii::$app->getSession()->hasFlash('success')): ?>
        <?php
        echo '<p class="text-success text-center"><b>' . Yii::$app->session->getFlash('success') . '</b></p>'; ?>
    <?php
    else: ?>
        <?php
        echo '<p class="text-danger text-center"><b>' . Yii::$app->session->getFlash('error') . '</b></p>'; ?>
    <?php
    endif; ?>
</div>
<div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg">Login to start your session</p>

        <?php
        $form = ActiveForm::begin(['id' => 'login-form']) ?>

        <?= $form->field(
            $model,
            'username',
            [
                'options' => ['class' => 'form-group has-feedback'],
                'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div>',
                'template' => '{beginWrapper}{label}{input}{error}{hint}{endWrapper}',
                'wrapperOptions' => ['class' => 'input-group mb-3']
            ]
        )
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

        <?= $form->field(
            $model,
            'password',
            [
                'options' => ['class' => 'form-group has-feedback'],
                'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>',
                'template' => '{beginWrapper}{label}{input}{error}{endWrapper}',
                'wrapperOptions' => ['class' => 'input-group mb-3']
            ]
        )
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

        <div class="row">
           <!-- <div class="col-8">
                <?/*= $form->field($model, 'rememberMe')->checkbox(
                    [
                        'template' => '<div class="icheck-primary">{input}{label}</div>',
                        'labelOptions' => [
                            'class' => ''
                        ],
                        'uncheck' => null
                    ]
                ) */?>
            </div>-->
            <div class="col-4">
                <?= Html::submitButton('Sign In', ['class' => 'btn btn-primary btn-block','name'=>'Sign In']) ?>
            </div>
        </div>

        <?php
        ActiveForm::end(); ?>

    </div>
    <!-- /.login-card-body -->
</div>