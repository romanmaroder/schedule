<?php



/* @var $this \yii\web\View */
/* @var $model \core\forms\manage\Expenses\Expense\ExpenseCreateForm */

use core\helpers\EventMethodsOfPayment;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('expenses/expenses','Create Expense');
$this->params['breadcrumbs'][] = ['label' => Yii::t('expenses/expenses','Expenses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <?php
    $form = ActiveForm::begin(
        [
            'options' => ['enctype' => 'multipart/form-data']
        ]
    ); ?>
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col">
            <div class="card card-secondary">
                <div class='card-header'>
                    <h3 class='card-title'><?=Yii::t('app','Common')?></h3>
                    <div class='card-tools'>
                        <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
                        </button>
                        <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?= $form->field($model, 'name')->textInput(
                                    ['maxlength' => true, 'placeholder' => $model->getAttributeLabel('name')]
                                )->label($model->getAttributeLabel('name')) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?= $form->field($model, 'value')->textInput(
                                    ['maxlength' => true, 'placeholder' => $model->getAttributeLabel('value')]
                                )->label($model->getAttributeLabel('value')) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?= $form->field($model, 'status')->textInput(
                                    ['maxlength' => true, 'placeholder' => $model->getAttributeLabel('status')]
                                )->label($model->getAttributeLabel('status')) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?= $form->field($model, 'payment')->widget(
                                    Select2::class,
                                    [
                                        'name' => 'status',
                                        'language' => 'ru',
                                        'data' => EventMethodsOfPayment::statusList(),
                                        'theme' => Select2::THEME_BOOTSTRAP,
                                        'options' => [
                                            'id' => 'status',
                                            'placeholder' => 'Select',
                                            'value' => 0,
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
            </div>

                    <div class="card card-secondary">
                        <div class='card-header'>
                            <h3 class='card-title'><?=Yii::t('expenses/category','Categories')?></h3>
                            <div class='card-tools'>
                                <button type='button' class='btn btn-tool' data-card-widget='maximize'><i
                                            class='fas fa-expand'></i>
                                </button>
                                <button type='button' class='btn btn-tool' data-card-widget='collapse'><i
                                            class='fas fa-minus'></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <?
                                        /*= $form->field($model->categories, 'main')->dropDownList(
                                                                $model->categories->categoriesList(),
                                                                ['prompt' => '']
                                                            ) */ ?>

                                        <?= $form->field($model->categories, 'main')->widget(
                                            Select2::class,
                                            [

                                                'bsVersion' => '4.x',
                                                'name' => 'kv_theme_select1a',
                                                'data' => $model->categories->categoriesList(),
                                                'theme' => Select2::THEME_KRAJEE_BS4, // this is the default if theme is not set
                                                'options' => ['placeholder' => 'Select a service ...'],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],

                                            ]
                                        ) ?>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?= $form->field($model->categories, 'others')->checkboxList(
                                                $model->categories->categoriesList(),
                                            ) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-secondary">
                        <div class='card-header'>
                            <h3 class='card-title'><?=Yii::t('expenses/tag','Tags')?></h3>
                            <div class='card-tools'>
                                <button type='button' class='btn btn-tool' data-card-widget='maximize'><i
                                            class='fas fa-expand'></i>
                                </button>
                                <button type='button' class='btn btn-tool' data-card-widget='collapse'><i
                                            class='fas fa-minus'></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <?= $form->field($model->tags, 'existing')->checkboxList($model->tags->tagsList()) ?>
                            </div>
                            <div class="form-group">
                                <?= $form->field($model->tags, 'textNew')->textInput(
                                    ['placeholder' => $model->getAttributeLabel('name')]
                                )->label($model->tags->getAttributeLabel('textNew')) ?>
                            </div>
                        </div>
                    </div>

            <div class="card-footer bg-secondary form-group">
                <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-success btn-shadow btn-sm btn-gradient']) ?>
            </div>
        </div>
    </div>
</div>
<?php
    ActiveForm::end(); ?>
