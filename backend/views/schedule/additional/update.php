<?php

use mihaildev\ckeditor\CKEditor;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model core\forms\manage\Schedule\Additional\AdditionalEditForm */
/* @var $additional  \core\entities\Schedule\Additional\Additional */

$this->title = Yii::t('schedule/additional','Update Additional: ') . $additional->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('schedule/additional','Additional'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $additional->name, 'url' => ['view', 'id' => $additional->id]];
$this->params['breadcrumbs'][] = Yii::t('app','Update');
?>

    <?php $form = ActiveForm::begin(); ?>
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col">
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
                <?=Yii::t('schedule/additional/category','Categories')?>
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
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
