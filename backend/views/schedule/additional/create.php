<?php

use kartik\widgets\Select2;
use mihaildev\ckeditor\CKEditor;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model core\forms\manage\Schedule\Additional\AdditionalCreateForm */

$this->title = Yii::t('schedule/additional', 'Create Additional');
$this->params['breadcrumbs'][] = ['label' => Yii::t('schedule/additional', 'Additional'), 'url' => ['index']];
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
                    <h3 class='card-title'><?= Yii::t('app', 'Common') ?></h3>
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
                                <?= $form->field($model, 'description')->widget(CKEditor::class)->label(
                                    $model->getAttributeLabel('description')
                                ) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-secondary">
                <div class='card-header'>
                    <h3 class='card-title'><?= Yii::t('schedule/additional/category', 'Categories') ?></h3>
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
                    <h3 class='card-title'>SEO</h3>
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
                        <?= $form->field($model->meta, 'title')->textInput(
                            ['maxlength' => true, 'placeholder' => $model->getAttributeLabel('title')]
                        )->label($model->meta->getAttributeLabel('title')) ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model->meta, 'description')->textarea(
                            ['rows' => 2, 'placeholder' => $model->getAttributeLabel('description')]
                        )->label($model->getAttributeLabel('description')) ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model->meta, 'keywords')->textInput(
                            ['maxlength' => true, 'placeholder' => $model->getAttributeLabel('keywords')]
                        )->label($model->meta->getAttributeLabel('keywords')) ?>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-secondary form-group">
                <?= Html::submitButton(
                    Yii::t('app', 'Save'),
                    ['class' => 'btn btn-success btn-sm btn-gradient btn-shadow']
                ) ?>
            </div>
        </div>
    </div>
</div>
<?php
ActiveForm::end(); ?>
