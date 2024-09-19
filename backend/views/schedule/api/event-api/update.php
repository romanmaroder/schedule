<?php

use core\helpers\DiscountHelper;
use core\helpers\EventPaymentStatusHelper;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $event \core\entities\Schedule\Event\Event */
/* @var $model\core\forms\manage\Schedule\Event\EventEditForm */


?>
<div class="event-update container-fluid">

    <?php
    $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-12">
            <div class="form-group"><?= $form->field($model, 'start')->widget(
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
                            //'hoursDisabled' => [0,1,2,3,4,5,6,22,23],
                            //'daysOfWeekDisabled' => [0,6],
                            'todayHighlight' => true,
                            'todayBtn' => true,
                        ],
                        'pluginEvents' => [
                            "show" => 'function() {
                                    let data_id = $("#master").val();
                                    console.log(data_id);
                                    $.ajax({
                                        url: "/schedule/event/check",
                                        method: "get",
                                        dataType: "json",
                                        data: {id: data_id},
                                        success: function(data){
                                           $("#eventeditform-start-datetime").datetimepicker("setDaysOfWeekDisabled", data.weekends);
                                           $("#eventeditform-end-datetime").datetimepicker("setDaysOfWeekDisabled", data.weekends);
                                           
                                           $("#eventeditform-start-datetime").datetimepicker("setHoursDisabled", data.hours);
                                            $("#eventeditform-end-datetime").datetimepicker("setHoursDisabled", data.hours);
                                           console.log(data)
                                        },
                                        error: function(data , jqXHR, exception){
                                            console.log(exception)
                                        }
                                    });
                                    }',
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
                            //'hoursDisabled' => [0,1,2,3,4,5,6,22,23],
                            //'daysOfWeekDisabled' => [0,6],
                            'todayHighlight' => true,
                            'todayBtn' => true,
                        ],
                        'language' => 'ru',
                        'size' => 'xs'

                    ]
                ) ?></div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <?= $form->field($model->master, 'master')->widget(
                    Select2::class,
                    [
                        'name' => 'master',
                        'language' => 'ru',
                        'data' => $model->master->masterList(),
                        'options' => [
                            //'id' => 'master',
                            'placeholder' => 'Select'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
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
            <div class="form-group"> <?= $form->field($model->client, 'client')->widget(
                    Select2::class,
                    [
                        'name' => 'client',
                        'language' => 'ru',
                        'data' => $model->client->userList(),
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
                        'data' => $model->services->servicesList(),
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
                )?>
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
                    ['class' => $model->discount ? 'discount form-control' : 'discount d-none']
                )->label(
                    $model->getAttributeLabel('discount'),
                    ['class' => $model->discount ? 'discount control-label' : 'discount d-none']
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
            <div class="form-group"> <?= $form->field($model, 'notice')->textarea(
                    ['maxlength' => true, 'row' => 5]
                ) ?></div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <?= $form->field($model, 'tools')->widget(
                    Select2::class,
                    [
                        'name' => 'tools',
                        'language' => 'ru',
                        'data' => \core\helpers\ToolsHelper::statusList(),
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'options' => [
                            'id' => 'tools',
                            'placeholder' => 'Select',
                            'multiple' => false,
                            'autocomplete' => 'on',
                        ],
                        'pluginOptions' => [
                            'tags' => false,
                            'allowClear' => false,
                        ],
                    ]
                ) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group"> <?= Html::submitButton(
                    'Save',
                    ['class' => 'btn btn-success btn-sm btn-shadow bg-gradient']
                ) ?></div>
        </div>
    </div>


    <?php
    ActiveForm::end(); ?>

</div>
