<?php

use core\helpers\PriceHelper;
use kartik\datetime\DateTimePicker;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use core\helpers\DiscountHelper;
use core\helpers\EventPaymentStatusHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\Schedule\Event\EventCreateForm */

$this->title = Yii::t('schedule/event','Create Event');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','Events'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="event-create container-fluid">

    <?php

    $form = ActiveForm::begin(
        [
            'id' => 'event-form',
            'enableAjaxValidation' => false,
        ]
    ); ?>
    <div class="card card-secondary">
        <div class='card-header'>
            <h3 class='card-title'><?=Yii::t('schedule/event','New event')?></h3>
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
                    <div class="form-group"> <?= $form->field($model->master, 'master')->widget(
                            Select2::class,
                            [
                                'name' => 'master',
                                'language' => 'ru',
                                'data' => $model->master->masterList(),
                                'options' => ['placeholder' => 'Select'],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'id' => 'master',
                                ],
                                'pluginEvents' => [
                                    "change" => 'function() {
                                    let data_id = $(this).val();
                                    $.ajax({
                                        url: "/employee/schedule",
                                        method: "get",
                                        dataType: "json",
                                        data: {id: data_id},
                                        success: function(data){
                                           $("#eventcreateform-start-datetime").datetimepicker("setDaysOfWeekDisabled", data.weekends);
                                           $("#eventcreateform-end-datetime").datetimepicker("setDaysOfWeekDisabled", data.weekends);
                                           
                                           $("#eventcreateform-start-datetime").datetimepicker("setHoursDisabled", data.hours);
                                           $("#eventcreateform-end-datetime").datetimepicker("setHoursDisabled", data.hours);
                                        
                                        },
                                        error: function(data , jqXHR, exception){
                                            console.log(exception)
                                        }
                                    });
                                    $.ajax({
                                        url: "/employee/price-list",
                                        method: "get",
                                        dataType: "json",
                                        data: {id: data_id},
                                        success: function(data){
                                          
                                           $("select#lists").html(data.out).attr("disabled", false);
                                        },
                                        error: function(data , jqXHR, exception){
                                            console.log(exception)
                                        }
                                    });
                                    
                                    
                                    }',
                                ],
                            ]
                        ); ?></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group"> <?= $form->field($model, 'start')->widget(
                            DateTimePicker::class,
                            [
                                'options' => [
                                    'placeholder' => 'Начало события ...',
                                    'type' => 'text',
                                    'readonly' => true,
                                    'class' => 'text-muted small',
                                    'style' => 'border:none;background:none',
                                    'convertFormat' => true
                                ],
                                'type' => DateTimePicker::TYPE_BUTTON,
                                'layout' => '{picker} {remove} {input}',
                                'pickerIcon' => '<i class="fa fa-calendar"></i>',
                                'removeIcon' => '<i class="fa fa-times"></i>',
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd H:ii:ss',
                                    'todayHighlight' => true,
                                    'todayBtn' => true,
                                    //'daysOfWeekDisabled' => [0,6],
                                    //'hoursDisabled' => [0, 1, 2, 3, 4, 5, 6, 22, 23],
                                ],
                                'language' => 'ru',
                                'size' => 'xs'
                            ]
                        ) ?></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group"><?= $form->field($model, 'end')->widget(
                            DateTimePicker::class,
                            [
                                'options' => [
                                    'placeholder' => 'Конец события ...',
                                    'type' => 'text',
                                    'readonly' => true,
                                    'class' => 'text-muted small',
                                    'style' => 'border:none;background:none'
                                ],
                                'type' => DateTimePicker::TYPE_BUTTON,
                                'layout' => '{picker} {remove} {input}',
                                'pickerIcon' => '<i class="fa fa-calendar"></i>',
                                'removeIcon' => '<i class="fa fa-times"></i>',
                                'pluginOptions' => [
                                    'format' => 'yyyy-mm-dd H:ii:ss',
                                    'autoclose' => true,
                                    'todayHighlight' => true,
                                    'todayBtn' => true,
                                    //'daysOfWeekDisabled' => [0,6],
                                    //'hoursDisabled' => [0, 1, 2, 3, 4, 5, 6, 22, 23]
                                ],
                                'language' => 'ru',
                                'size' => 'xs'

                            ]
                        ) ?></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group"> <?= $form->field($model->client, 'client')->widget(
                            Select2::class,
                            [
                                'name' => 'client',
                                'language' => 'ru',
                                'data' => $model->client->userList(),
                                'options' => ['placeholder' => 'Select'],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                ],
                            ]
                        ) ?></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">

                        <?= $form->field($model->services, 'lists')->widget(
                            Select2::class,
                            [
                                'name' => 'lists',
                                'language' => 'ru',
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
                            ]
                        ) ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'discount_from')->widget(
                            Select2::class,
                            [
                                'name' => 'discount_from',
                                'language' => 'ru',
                                'data' => DiscountHelper::discountList(),
                                'theme' => Select2::THEME_BOOTSTRAP,
                                'options' => [
                                    'id' => 'discountFrom',
                                    'placeholder' => 'Select',
                                    'value' => 0,
                                    'multiple' => false,
                                    'autocomplete' => 'on',
                                ],
                                'pluginOptions' => [
                                    'tags' => false,
                                    'allowClear' => false,
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
                        ) ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'discount')->input(
                            'text',
                            ['class' => 'discount form-control d-none']
                        )->label(
                            $model->getAttributeLabel('discount'),
                            ['class' => 'discount control-label d-none']
                        ) ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <?= $form->field($model, 'status')->widget(
                            Select2::class,
                            [
                                'name' => 'status',
                                'language' => 'ru',
                                'data' => EventPaymentStatusHelper::statusList(),
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
                <div class="col-12">
                    <div class="form-group"> <?= $form->field($model, 'amount')->hiddenInput()->label(false) ;?></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group"><?= $form->field($model, 'notice')->textarea(
                            ['maxlength' => true, 'row' => 5]
                        ) ?></div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-success btn-sm btn-shadow bg-gradient text-shadow']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    ActiveForm::end(); ?>

</div>


