<?php


/* @var $this \yii\web\View */

/* @var $model \core\forms\manage\Expenses\Expense\ExpenseEditForm */

/* @var $expense \core\entities\Expenses\Expenses\Expenses */

use core\helpers\EventMethodsOfPayment;
use kartik\date\DatePicker;
use kartik\widgets\Select2;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('expenses/expenses','Update Expense: ') . $expense->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('expenses/expenses','Expenses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $expense->name, 'url' => ['view', 'id' => $expense->id]];
$this->params['breadcrumbs'][] = Yii::t('app','Update');
?>
<div class="expense-update">

    <?php
    $form = ActiveForm::begin(); ?>


    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title ">
               <?=Yii::t('app',' Common')?>
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
                <div class="col-md-6">
                    <?= $form->field($model, 'value')->textInput() ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <?= $form->field($model, 'payment')->widget(
                            Select2::class,
                            [
                                'name' => 'payment',
                                'language' => 'ru',
                                'data' => EventMethodsOfPayment::statusList(),
                                'theme' => Select2::THEME_BOOTSTRAP,
                                'options' => [
                                    'id' => 'payment',
                                    'placeholder' => 'Select',
                                    'multiple' => false,
                                    'autocomplete' => 'on',
                                ],
                                'pluginOptions' => [
                                    'tags' => false,
                                    'allowClear' => false,
                                ],
                                /*'pluginEvents' => [
                                    "change" => 'function() {
                                            let data_id = $(this).val();
                                            let discount = $(".discount");

                                            if(data_id > 0) {
                                                discount.each(function() {
                                                        $(this).removeClass( "d-none");
                                                        $(this).attr( "required" );
                                                    });
                                            }else{
                                                discount.each(function() {
                                                        $(this).addClass( "d-none");
                                                    });
                                            }

                                            }',
                                ],*/
                            ]
                        ) ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <?= $form->field($model, 'created_at')->widget(
                            DatePicker::class,
                            [
                                'options' => [
                                    'type' => 'text',
                                    'readonly' => true,
                                    'convertFormat' => true,
                                    'value'=>date('Y-m-d',$model->created_at),
                                ],
                                'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                                'layout' => '{picker} {remove} {input}',
                                'pickerIcon' => '<i class="fa fa-calendar"></i>',
                                'removeIcon' => '<i class="fa fa-times"></i>',
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd',
                                    'todayHighlight' => true,
                                    'todayBtn' => true,
                                    //'daysOfWeekDisabled' => [0,6],
                                    //'hoursDisabled' => [0, 1, 2, 3, 4, 5, 6, 22, 23],
                                ],
                                'language' => 'ru',
                                'size' => 'xs'
                            ]
                        ) ?>
                    </div>
                </div>
            </div>
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
                <?=Yii::t('expenses/category','Categories')?>

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
             <?=Yii::t('expenses/tag','Tags')?>
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
            <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-success btn-shadow btn-sm btn-gradient']) ?>
        </div>
        <!--Footer-->
    </div>
    <!-- /.card-footer-->
</div>

<?php
ActiveForm::end(); ?>


</div>