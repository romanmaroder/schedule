<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var schedule\forms\manage\User\UserEditForm $model */
/** @var schedule\entities\User\User $user */

$this->title = 'Update User: ' . $user->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->id, 'url' => ['view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = 'Update';
?><?php $form = ActiveForm::begin(); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
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
        <?= $form->field($model, 'username')->textInput(['maxLength' => true]) ?>
        <?= $form->field($model, 'email')->textInput(['maxLength' => true]) ?>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <!--Footer-->
    </div>
    <!-- /.card-footer-->
</div>

<?php ActiveForm::end(); ?>
