<?php

use schedule\helpers\UserHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var schedule\entities\user\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<?php $form = ActiveForm::begin(); ?>
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
        <?= $form->field($model, 'status')->dropDownList(UserHelper::statusList()) ?>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <!--Footer-->
    </div>
    <!-- /.card-footer-->
</div>

<?php ActiveForm::end(); ?>

