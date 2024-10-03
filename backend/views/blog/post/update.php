<?php

/* @var $this yii\web\View */
/* @var $post core\entities\Blog\Post\Post */
/* @var $model core\forms\manage\Blog\Post\PostForm */

//$this->title = Yii::t('blog','Update Post: ') . $post->title;
use yii\helpers\Html;
use yii\helpers\StringHelper;

$this->title =Yii::t('blog','Update Post: ') .Html::encode( StringHelper::truncateWords(strip_tags( $post->title), 3));
$this->params['breadcrumbs'][] = ['label' => Yii::t('blog','Post'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Html::encode( StringHelper::truncateWords(strip_tags($post->title),3)), 'url' => ['view', 'id' => $post->id]];
$this->params['breadcrumbs'][] = Yii::t('app','Update');
?>
<div class="post-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>