<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

/** @var yii\web\View $this */
/** @var schedule\forms\manage\User\UserEditForm $model */
/** @var schedule\entities\User\User $user */

$this->title = 'Update User: ' . $user->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->id, 'url' => ['view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<?php $form = ActiveForm::begin(); ?>
<div class="card card-secondary">
    <div class="card-header">
        <h3 class="card-title">
           Common
        </h3>

        <div class='card-tools'>
            <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
            </button>
            <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <?= $form->field($model, 'username')->textInput(['maxLength' => true]) ?>
        <?= $form->field($model, 'email')->textInput(['maxLength' => true]) ?>
        <?= $form->field($model, 'phone')->widget(MaskedInput::class, [
            'mask' => '+9[9][9] (999) 999-99-99',
        ])->textInput(['placeholder' => $model->getAttributeLabel('phone')])->label($model->getAttributeLabel('phone')) ?>

        <?= $form->field($model, 'discount')->textInput(['maxLength' => true]) ?>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <!--Footer-->
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-shadow']) ?>
    </div>
    <!-- /.card-footer-->
</div>

<?php ActiveForm::end(); ?>
