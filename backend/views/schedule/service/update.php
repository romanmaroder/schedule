<?php

use mihaildev\ckeditor\CKEditor;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $service \core\entities\Expenses\Expenses\Expenses */
/* @var $model core\forms\manage\Schedule\Service\ServiceEditForm */

$this->title = Yii::t('schedule/service','Update Service: ') . $service->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('schedule/service','Services'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $service->name, 'url' => ['view', 'id' => $service->id]];
$this->params['breadcrumbs'][] = Yii::t('app','Update');
?>
<div class="service-update">

    <?php $form = ActiveForm::begin(); ?>


    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title ">
                <?=Yii::t('app','Common')?>
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
            <?= $form->field($model, 'description')->widget(CKEditor::class) ?>
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
                <?=Yii::t('schedule/service/category','Categories')?>

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
                <?=Yii::t('schedule/service/tag','Tags')?>
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
    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title ">
                SEO
            </h3>
            <div class='card-tools'>
                <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
                </button>
                <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <?= $form->field($model->meta, 'title')->textInput() ?>
            <?= $form->field($model->meta, 'description')->textarea(['rows' => 2]) ?>
            <?= $form->field($model->meta, 'keywords')->textInput() ?>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-success btn-sm btn-gradient btn-shadow']) ?>
            </div>
            <!--Footer-->
        </div>
        <!-- /.card-footer-->
    </div>

    <?php ActiveForm::end(); ?>


</div>