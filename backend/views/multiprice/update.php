<?php



/* @var $this \yii\web\View */
/* @var $model \core\forms\manage\User\MultiPrice\MultiPriceEditForm*/
/* @var $price null|\core\entities\User\MultiPrice */

use hail812\adminlte3\assets\PluginAsset;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\ActiveForm;

$this->title = 'Update Multi price: ' . $price->name;
$this->params['breadcrumbs'][] = ['label' => 'Multi Prices', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $price->name, 'url' => ['view', 'id' => $price->id]];
$this->params['breadcrumbs'][] = 'Update';

YiiAsset::register($this);
PluginAsset::register($this)->add(['sweetalert2']);
?>

<div class="multiprice-update container-fluid">

    <?php
    $form = ActiveForm::begin(); ?>
    <div class="card card-secondary">
        <div class='card-header'>
            <h3 class='card-title'><?= $price->name; ?></h3>
            <div class='card-tools'>
                <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
                </button>
                <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="form-group"> <?= $form->field($model, 'name')->textInput() ?></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group"> <?= $form->field($model, 'rate')->textInput() ?></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group"> <?= $form->field($model->services, 'lists')->widget(
                            Select2::class,
                            [
                                'name' => 'lists',
                                'language' => 'ru',
                                'data' => $model->services->servicesList(),
                                'theme' => Select2::THEME_BOOTSTRAP,
                                'options' => [
                                    'id' => 'lists',
                                    'placeholder' => 'Select',
                                    'multiple' => true,
                                    'autocomplete' => 'off',
                                ],
                                'pluginOptions' => [
                                    'tags' => true,
                                    'allowClear' => true,
                                ],
                                'pluginEvents' => [
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
                                ],
                            ]
                        ) ?></div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-12">
                    <div class="form-group"> <?= Html::submitButton(
                            'Save',
                            ['class' => 'btn btn-success btn-sm btn-shadow bg-gradient']
                        ) ?></div>
                </div>
            </div>
        </div>
    </div>

    <?php
    ActiveForm::end(); ?>

</div>