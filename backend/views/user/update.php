<?php

use core\helpers\ScheduleHelper;
use core\helpers\UserHelper;
use kartik\widgets\Select2;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

/** @var yii\web\View $this */
/** @var core\forms\manage\User\UserEditForm $model */
/** @var core\entities\User\User $user */

$this->title = Yii::t('user','Update User: ') . $user->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('user','Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $user->username;
?>

<?php $form = ActiveForm::begin(); ?>
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">
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
                    <?= $form->field($model, 'username')->textInput(['maxLength' => true]) ?>
                    <?= $form->field($model, 'email')->textInput(['maxLength' => true]) ?>
                    <?= $form->field($model, 'phone')->widget(
                        MaskedInput::class,
                        [
                            'mask' => '+9[9][9] (999) 999-99-99',
                        ]
                    )->textInput(['placeholder' => $model->getAttributeLabel('phone')])->label(
                        $model->getAttributeLabel('phone')
                    ) ?>
                    <?= $form->field($model, 'password')->passwordInput(
                        ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('password')]
                    )->label($model->getAttributeLabel('password')) ?>
                    <?= $form->field($model, 'status')->widget(
                        Select2::class,
                        [
                            'bsVersion' => '4.x',
                            'name' => 'status',
                            'data' => UserHelper::statusList(),
                            'theme' => Select2::THEME_KRAJEE_BS4, // this is the default if theme is not set
                            'options' => ['placeholder' => 'Select a status ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],

                        ]
                    ) ?>
                    <div class="form-group">
                        <?= $form->field($model->schedule, 'hoursWork')->widget(
                            Select2::class,
                            [
                                'name' => 'hoursWork',
                                'language' => 'ru',
                                'data' => ScheduleHelper::hours(),
                                'theme' => Select2::THEME_BOOTSTRAP,
                                'options' => [
                                    'id' => 'hoursWork',
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
                    <div class="form-group">
                        <?= $form->field($model->schedule, 'weekends')->widget(
                            Select2::class,
                            [
                                'name' => 'weekends',
                                'language' => 'ru',
                                'data' => ScheduleHelper::days(),
                                'theme' => Select2::THEME_BOOTSTRAP,
                                'options' => [
                                    'id' => 'weekends',
                                    'placeholder' => 'Select',
                                    'multiple' => true,
                                    'autocomplete' => 'off',
                                ],
                                'pluginOptions' => [
                                    'tags' => true,
                                    'allowClear' => true,
                                ],
                            ]
                        ) ->label($model->schedule->getAttributeLabel('days'))?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model->schedule, 'week')->textInput(
                            ['maxLength' => true, 'placeholder' => $model->schedule->getAttributeLabel('week')]
                        )->label($model->schedule->getAttributeLabel('week')) ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model, 'notice')->textarea(
                            ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('notice'),'row'=>5,]
                        )->label($model->getAttributeLabel('notice')) ?>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <!--Footer-->
                    <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-success btn-shadow btn-sm btn-gradient']) ?>
                </div>
                <!-- /.card-footer-->
            </div>
        </div>
    </div>
</div>
<?php
ActiveForm::end(); ?>
