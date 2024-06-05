<?php


/* @var $this \yii\web\View */

/* @var $model \core\forms\manage\Expenses\Expense\ExpenseEditForm */

/* @var $expense \core\entities\Expenses\Expenses\Expenses */

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = 'Update Expense: ' . $expense->name;
$this->params['breadcrumbs'][] = ['label' => 'Expenses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $expense->name, 'url' => ['view', 'id' => $expense->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="expense-update">

    <?php
    $form = ActiveForm::begin(); ?>


    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title ">
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
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <?= $form->field($model, 'value')->textInput() ?>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <!--Footer-->
        </div>
        <!-- /.card-footer-->
    </div>
    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title ">
                Categories
            </h3>
            <div class='card-tools'>
                <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
                </button>
                <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            <?= $form->field($model->categories, 'main')->dropDownList(
                $model->categories->categoriesList(),
                ['prompt' => '']
            ) ?>
            <?= $form->field($model->categories, 'others')->checkboxList($model->categories->categoriesList()) ?>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <!--Footer-->
        </div>
        <!-- /.card-footer-->
    </div>
    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title ">
                Tags
            </h3>
            <div class='card-tools'>
                <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
                </button>
                <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <?= $form->field($model->tags, 'existing')->checkboxList($model->tags->tagsList()) ?>
            <?= $form->field($model->tags, 'textNew')->textInput() ?>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <!--Footer-->
        </div>
        <!-- /.card-footer-->
    </div>

    <!-- /.card-body -->
    <div class="card-footer">
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-shadow btn-sm btn-gradient']) ?>
        </div>
        <!--Footer-->
    </div>
    <!-- /.card-footer-->
</div>

<?php
ActiveForm::end(); ?>


</div>