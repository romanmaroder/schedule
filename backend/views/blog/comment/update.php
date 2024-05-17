<?php


/* @var $this \yii\web\View */

/* @var $post \schedule\entities\Blog\Post\Post */
/* @var $model \schedule\forms\manage\Blog\Post\CommentEditForm */

/* @var $comment \schedule\entities\Blog\Post\Comment */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Update Post: ' . $post->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $post->title, 'url' => ['view', 'id' => $post->id]];
$this->params['breadcrumbs'][] = 'Update';
?>


<?php
$form = ActiveForm::begin(
    [
        'options' => ['enctype' => 'multipart/form-data']
    ]
); ?>

<div class="card card-secondary">
    <div class="card-header">
        <h3 class="card-title">Common</h3>
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
            <?= Html::submitButton('Save', ['class' => 'btn btn-sm btn-success btn-shadow btn-gradient']) ?>
        </div>
    </div>
</div>
<?php
ActiveForm::end(); ?>
