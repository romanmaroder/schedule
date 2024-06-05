<?php



/* @var $this \yii\web\View */
/* @var $model \core\forms\manage\Expenses\Expense\ExpenseCreateForm */

use kartik\widgets\Select2;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = 'Create Expense';
$this->params['breadcrumbs'][] = ['label' => 'Expemses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expense-create">

    <?php
    $form = ActiveForm::begin(
        [
            'options' => ['enctype' => 'multipart/form-data']
        ]
    ); ?>
    <div class="card card-secondary">
        <div class='card-header'>
            <h3 class='card-title'>Common</h3>
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
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class='card-header'>
                    <h3 class='card-title'>Categories</h3>
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
        </div>
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class='card-header'>
                    <h3 class='card-title'>Tags</h3>
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
                        )->label($model->getAttributeLabel('textNew')) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer bg-secondary form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-shadow btn-sm btn-gradient']) ?>
    </div>

    <?php
    ActiveForm::end(); ?>

</div>