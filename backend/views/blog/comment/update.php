<?php


/* @var $this \yii\web\View */

/* @var $post \core\entities\Blog\Post\Post */
/* @var $model \core\forms\manage\Blog\Post\CommentEditForm */

/* @var $comment \core\entities\Blog\Post\Comment */

use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\widgets\ActiveForm;

$this->title = Yii::t('blog','Update Post: ') .Html::encode( StringHelper::truncateWords(strip_tags($post->title), 3) );
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog','Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Html::encode( StringHelper::truncateWords(strip_tags($post->title), 3) ), 'url' => ['view', 'post_id'=>$post->id,'id' => $comment->id]];
$this->params['breadcrumbs'][] =  Yii::t('app','Update');
?>


<?php
$form = ActiveForm::begin(
    [
        'options' => ['enctype' => 'multipart/form-data']
    ]
); ?>
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title"><?= Yii::t('app','Common')?></h3>
        <div class='card-tools'>
            <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
            </button>
            <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="form-group">
            <?= $form->field($model, 'parentId')->textInput() ?>
        </div>
        <div class="form-group">
            <?= $form->field($model, 'text')->textarea(['rows' => 20]) ?>
        </div>
    </div>
    <div class="card-footer">
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-sm btn-success btn-shadow btn-gradient']) ?>
        </div>
    </div>
            </div>
        </div>
    </div>
</div>
<?php
ActiveForm::end(); ?>
