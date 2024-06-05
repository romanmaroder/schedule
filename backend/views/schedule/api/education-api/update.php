<?php



/* @var $this \yii\web\View */
/* @var $model \core\forms\manage\Schedule\Event\EducationEditForm */
/* @var $education \core\entities\Schedule\Event\Education */

use kartik\datetime\DateTimePicker;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;

?>
<div class="education-update container-fluid">

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
                            'hoursDisabled' => '0,1,2,3,4,5,6,22,23',
                            'todayHighlight' => true,
                            'todayBtn' => true,
                        ],

                        'language' => 'ru',
                        'size' => 'xs'
                    ]
                ); ?></div>
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
                            'hoursDisabled' => '0,1,2,3,4,5,6,22,23',
                            'todayHighlight' => true,
                            'todayBtn' => true,
                        ],
                        'language' => 'ru',
                        'size' => 'xs'

                    ]
                ); ?></div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group"><?= $form->field($model->teacher, 'teacher')->widget(
                    Select2::class,
                    [
                        'name' => 'teacher',
                        'language' => 'ru',
                        'data' => $model->teacher->teacherList(),
                        'options' => ['placeholder' => 'Select'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                        /*'pluginEvents'  => [
                            "change" => 'function() {
                            var data_id = $(this).val();
                            $.ajax({
                                url: "/calendar/event/user-service",
                                method: "get",
                                dataType: "json",
                                data: {id: data_id},
                                success: function(data){
                                   $("select#serviceUser").html(data).attr("disabled", false);
                                },
                                error: function(data , jqXHR, exception){
                                    var Toast = Swal.mixin({
                                                      toast: true,
                                                      position: "top-end",
                                                      showConfirmButton: false,
                                                      timer: 5000,
                                                    });
                                      Toast.fire({
                                        icon: "error",
                                        title: data.responseJSON.message
                                      });
                                }
                            });
                            }',
                        ],*/
                    ]
                ); ?></div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <?= $form->field($model->students, 'students')->widget(
                    Select2::class,
                    [
                        'name' => 'students',
                        'language' => 'ru',
                        'data' => $model->students->studentList(),
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'options' => [
                            'id' => 'students',
                            'placeholder' => 'Select',
                            'multiple' => true,
                            'autocomplete' => 'off',
                        ],
                        'pluginOptions' => [
                            'tags' => true,
                            'allowClear' => true,
                        ],
                    ]
                ) ?></div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group"><?= $form->field($model, 'title')->textInput(['maxlength' => true]); ?></div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group"><?= $form->field($model, 'description')->textarea(['maxlength' => true, 'row' => 5]); ?></div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group"> <?
                /*= $form->field($model, 'color')->textInput(['maxlength' => true]); */ ?></div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-sm btn-shadow bg-gradient text-shadow']); ?>
            </div>
        </div>
    </div>

    <?php
    ActiveForm::end(); ?>

</div>
