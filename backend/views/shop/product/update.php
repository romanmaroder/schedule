<?php

use mihaildev\ckeditor\CKEditor;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $product \core\entities\Shop\Product\Product */
/* @var $model \core\forms\manage\Shop\Product\ProductEditForm */

$this->title = Yii::t('shop/product', 'Update Product: ') . $product->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop/product', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $product->name, 'url' => ['view', 'id' => $product->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<?php
$form = ActiveForm::begin(); ?>
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title ">
                            <?= Yii::t('app', 'Common') ?>
                        </h3>
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
                <div class="col-md-4">
                    <?= $form->field($model, 'brandId')->dropDownList($model->brandsList()) ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
                </div>
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
                        <h3 class="card-title">
                            <?=Yii::t('shop/product','Warehouse')?>
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
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <?= $form->field($model, 'weight')->textInput(['maxlength' => true]) ?>
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
                            <?=Yii::t('shop/product','categories')?>
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
                        <?= $form->field($model->categories, 'main')->dropDownList($model->categories->categoriesList(), ['prompt' => '']) ?>
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
                            <?=Yii::t('shop/product','tags')?>
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
                            <?=Yii::t('shop/characteristic','Characteristic')?>
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
                        <?php foreach ($model->values as $i => $value): ?>
                            <?php if ($variants = $value->variantsList()): ?>
                                <?= $form->field($value, '[' . $i . ']value')->dropDownList($variants, ['prompt' => '']) ?>
                            <?php else: ?>
                                <?= $form->field($value, '[' . $i . ']value')->textInput() ?>
                            <?php endif ?>
                        <?php endforeach; ?>
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