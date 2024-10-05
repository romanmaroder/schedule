<?php

/* @var $this yii\web\View */

/* @var $model core\entities\Blog\Post\Post */

use yii\helpers\Html;
use yii\helpers\Url;

$url = Url::to(['post', 'id' => $model->id]);
?>


<div class="post">
    <div class="user-block">
        <?php
        if ($model->files): ?>
            <a href="<?= Html::encode($url) ?>">
                <img src="<?= Html::encode($model->getThumbFileUrl('files', 'blog_list')) ?>" alt="user image"
                     class="img-circle img-bordered-sm img-shadow"/>
            </a>
        <?php
        endif; ?>
        <span class="username">
                          <a href="<?= Html::encode($url) ?>"><?= Html::encode($model->title) ?></a>
                        </span>
        <span class="description"><i class="far fa-calendar-alt"></i> <?= Yii::$app->formatter->asDatetime($model->created_at); ?></span>
    </div>
    <!-- /.user-block -->
    <p>
        <?= Yii::$app->formatter->asNtext($model->description) ?>
    </p>

    <p>
        <a href="<?= Html::encode($url) ?>" class="link-black text-sm"><i class="fas fa-link mr-1"></i><?=Yii::t('app','Read more...')?></a>
    </p>
</div>




