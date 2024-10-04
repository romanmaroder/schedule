<?php



/* @var $this \yii\web\View */
/* @var $model \core\forms\manage\Shop\Product\ReviewEditForm */
/* @var $review \core\entities\Shop\Product\Review */
/* @var $product \core\entities\Shop\Product\Product */


use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('shop/review','Update Review: ') . $review->vote;
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop/review','Reviews'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $review->vote, 'url' => ['view','product_id'=>$product->id ,'id'=>$review->id]];
$this->params['breadcrumbs'][] = Yii::t('app','Update');
?>


<?php
$form = ActiveForm::begin(
    [
        'options' => ['enctype' => 'multipart/form-data']
    ]
); ?>

    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title"><?=Yii::t('shop/review','Review')?></h3>
            <div class='card-tools'>
                <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
                </button>
                <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group">
                <?= $form->field($model, 'vote')->textInput() ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'text')->textarea(['rows' => 10]) ?>
            </div>
        </div>
        <div class="card-footer">
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-sm btn-success btn-shadow btn-gradient']) ?>
            </div>
        </div>
    </div>
<?php
ActiveForm::end(); ?>