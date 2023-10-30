<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var schedule\forms\manage\User\UserCreateForm $model */

$this->title = 'Create User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin(); ?>
<div class="card card-secondary">
    <div class="card-header">
        <h3 class="card-title">
            Common
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="form-group">
            <?= $form->field($model, 'username')->textInput(
                ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('username')]
            )->label($model->getAttributeLabel('username')) ?>
        </div>
        <div class="form-group">
            <?= $form->field($model, 'email')->textInput(
                ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('email')]
            )->label($model->getAttributeLabel('email')) ?>
        </div>
        <div class="form-group">
            <?= $form->field($model, 'password')->passwordInput(['maxLength' => true, 'placeholder' => $model->getAttributeLabel('password')]
            )->label($model->getAttributeLabel('password'))?>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <!-- /.card-footer-->
</div>

<?php
ActiveForm::end(); ?>
