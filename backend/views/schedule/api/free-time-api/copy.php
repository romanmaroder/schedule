<?php



/* @var $this \yii\web\View */
/* @var $model \core\forms\manage\Schedule\Event\FreeTime\FreeTimeCopyForm */
/* @var $free \core\entities\Schedule\Event\FreeTime */

use kartik\widgets\DateTimePicker;
use kartik\widgets\Select2;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

?>
<div class="free-time-copy container-fluid">

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
                                           $("#eventcopyform-start-datetime").datetimepicker("setDaysOfWeekDisabled", data.weekends);
                                           $("#eventcopyform-end-datetime").datetimepicker("setDaysOfWeekDisabled", data.weekends);
                                           
                                           $("#eventcopyform-start-datetime").datetimepicker("setHoursDisabled", data.hours);
                                            $("#eventcopyform-end-datetime").datetimepicker("setHoursDisabled", data.hours);
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
            <div class="form-group"> <?= $form->field($model->master, 'master')->widget(
                    Select2::class,
                    [
                        'name' => 'master',
                        'language' => 'ru',
                        'data' => $model->master->masterList(),
                        'options' => [
                            'id' => 'master',
                            'autocomplete' => 'off',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                        'pluginEvents' => [
                            "change" => 'function() {
                                    let data_id = $(this).val();
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
                    ]
                ); ?></div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group"> <?= $form->field($model->additional, 'additional')->widget(
                    Select2::class,
                    [
                        'name' => 'client',
                        'language' => 'ru',
                        'data' => $model->additional->additionalList(),
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]
                ) ?></div>
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
            <div class="form-group"> <?= Html::submitButton(
                    'Save',
                    ['class' => 'btn btn-success btn-shadow btn-sm btn-gradient']
                ) ?></div>
        </div>
    </div>


    <?php
    ActiveForm::end(); ?>

</div>