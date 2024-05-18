<?php



use kartik\color\ColorInput;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use schedule\forms\manage\User\Employee\EmployeeExistCreateForm;
use schedule\helpers\EmployeeHelper;
use schedule\helpers\PriceHelper;
use schedule\helpers\RateHelper;
use schedule\helpers\RoleHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

/* @var $this \yii\web\View */
/* @var $model EmployeeExistCreateForm */

$this->title = 'Create Existing Employee';
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


?>
<?php $form = ActiveForm::begin(); ?>
    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title">
                Common
            </h3>

            <div class='card-tools'>
                <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
                </button>
                <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group">
                <?= $form->field($model, 'userId')->widget(
                    Select2::class,
                    [
                        'bsVersion' => '4.x',
                        'name' => 'userId',
                        'data' => $model->userList(),
                        'theme' => Select2::THEME_KRAJEE_BS4, // this is the default if theme is not set
                        'options' => ['placeholder' => 'Select a user ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],

                    ]
                ) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'rateId')->widget(
                    Select2::class,
                    [
                        'bsVersion' => '4.x',
                        'name' => 'rateId',
                        'data' => RateHelper::rateList(),
                        'theme' => Select2::THEME_KRAJEE_BS4, // this is the default if theme is not set
                        'options' => ['placeholder' => 'Select a rate ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],

                    ]
                )  ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'priceId')->widget(
                    Select2::class,
                    [
                        'bsVersion' => '4.x',
                        'name' => 'priceId',
                        'data' => PriceHelper::priceList(),
                        'theme' => Select2::THEME_KRAJEE_BS4, // this is the default if theme is not set
                        'options' => ['placeholder' => 'Select a price ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],

                    ]
                )  ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'phone')->widget(MaskedInput::class, [
                    'mask' => '+9[9][9] (999) 999-99-99',
                ])->textInput(['placeholder' => $model->getAttributeLabel('phone')])->label($model->getAttributeLabel('phone')) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'birthday')->widget(DatePicker::class, [
                    'options' => ['placeholder' => 'Enter birth date ...'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'dd.mm.yyyy'
                    ]
                ]) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'status')->widget(
                    Select2::class,
                    [
                        'bsVersion' => '4.x',
                        'name' => 'status',
                        'data' => EmployeeHelper::statusList(),
                        'theme' => Select2::THEME_KRAJEE_BS4, // this is the default if theme is not set
                        'options' => ['placeholder' => 'Select a status ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],

                    ]
                ) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model->address, 'town')->textInput(
                    ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('town')]
                )->label($model->getAttributeLabel('town')) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model->address, 'borough')->textInput(
                    ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('borough')]
                )->label($model->getAttributeLabel('borough')) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model->address, 'street')->textInput(
                    ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('street')]
                )->label($model->getAttributeLabel('street')) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model->address, 'home')->textInput(
                    ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('home')]
                )->label($model->getAttributeLabel('home')) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model->address, 'apartment')->textInput(
                    ['maxLength' => true, 'placeholder' => $model->getAttributeLabel('apartment')]
                )->label($model->getAttributeLabel('apartment')) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model->schedule, 'hoursWork')->widget(
                    Select2::class,
                    [
                        'name' => 'hoursWork',
                        'language' => 'ru',
                        'data' => [7,8,9,10],
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
                        'data' => [0,6],
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
                ) ?>
            </div>


            <div class="form-group">
                <?= $form->field($model, 'color')->widget(ColorInput::class, [
                    'options' => ['placeholder' => 'Select color ...'],
                ]) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'roleId')->widget(
                    Select2::class,
                    [
                        'bsVersion' => '4.x',
                        'name' => 'roleId',
                        'data' => RoleHelper::roleList(),
                        'theme' => Select2::THEME_KRAJEE_BS4, // this is the default if theme is not set
                        'options' => ['placeholder' => 'Select a role ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],

                    ]
                )  ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'role')->widget(
                    Select2::class,
                    [
                        'bsVersion' => '4.x',
                        'name' => 'roleId',
                        'data' => $model->rolesList(),
                        'theme' => Select2::THEME_KRAJEE_BS4, // this is the default if theme is not set
                        'options' => ['placeholder' => 'Select a role ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],

                    ]
                )  ?>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-shadow']) ?>
    </div>
    <!-- /.card-footer-->

<?php
ActiveForm::end(); ?>