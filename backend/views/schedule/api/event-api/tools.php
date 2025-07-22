<?php

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
        <div class="col-12 text-right">
            <div class="form-group"> <?= Html::submitButton(
                    Yii::t('app','Save'),
                    ['class' => 'btn btn-success btn-sm btn-shadow bg-gradient']
                ) ?></div>
        </div>
    </div>


    <?php
    ActiveForm::end(); ?>

</div>
