<?php

use kartik\widgets\DateTimePicker;
use kartik\widgets\Select2;
use yii\bootstrap4\ActiveForm;use yii\helpers\Html;



/* @var $this \yii\web\View */
/* @var $model \core\forms\manage\Schedule\Event\FreeTime\FreeTimeCreateForm */
?>
<div class="free-time-create container-fluid">

    <?php

    $form = ActiveForm::begin(
        [
            'id' => 'event-form',
            'enableAjaxValidation' => false,
        ]
    ); ?>

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
                                           $("#eventcreateform-start-datetime").datetimepicker("setDaysOfWeekDisabled", data.weekends);
                                           $("#eventcreateform-end-datetime").datetimepicker("setDaysOfWeekDisabled", data.weekends);
                                           
                                           $("#eventcreateform-start-datetime").datetimepicker("setHoursDisabled", data.hours);
                                           $("#eventcreateform-end-datetime").datetimepicker("setHoursDisabled", data.hours);
                                           
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
                            //'hoursDisabled' => [0,1,2,3,4,5,6,22,23]
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
            <div class="form-group"> <?= $form->field($model->additional, 'additional')->widget(
                    Select2::class,
                    [
                        'name' => 'client',
                        'language' => 'ru',
                        'data' => $model->additional->additionalList(),
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
            <div class="form-group"><?= $form->field($model, 'notice')->textarea(
                    ['maxlength' => true, 'row' => 5]
                ) ?></div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-success btn-sm btn-shadow bg-gradient']) ?>
            </div>
        </div>
    </div>

    <?php
    ActiveForm::end(); ?>

</div>