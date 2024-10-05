<?php


/* @var $this \yii\web\View */

/* @var $item array|\frontend\widgets\Blog\CommentView|mixed */

use yii\helpers\Html;
use yii\helpers\Url;

///* @var $item \frontend\widgets\Blog\CommentView */
?>


<ul class="comment-list" data-id="<?= $item->comment->id ?>">
    <li class="comment">
        <div class="vcard bio">
            <?php
            if ($item->comment->isEmployee()) : ?>
                <span><?= $item->comment->employee->user->getInitials() ?></span>
            <?php
            else: ?>
            <?= Html::img(Url::to('/img/logo.jpg')) ?>
            <?php
            endif; ?>
        </div>
        <div class="comment-body">
            <?php
            if ($item->comment->isEmployee()) : ?>
                <h3><?= $item->comment->employee->getFullName() ?></h3>
            <?php
            else: ?>
                <h3><?=Yii::t('app','Anonymous')?></h3>
            <?php
            endif; ?>
            <div class="meta"><?= Yii::$app->formatter->asDatetime($item->comment->created_at) ?></div>
            <p><?php
                if ($item->comment->isActive()): ?>
                    <?= Yii::$app->formatter->asNtext($item->comment->text) ?>
                <?php
                else: ?>
                    <i><?=Yii::t('blog/comments','Comment is deleted.')?></i>
                <?php
                endif; ?></p>
            <p><a href="#" class="reply btn-shadow"><?=Yii::t('blog/comments','Reply')?></a></p>
        </div>
        <ul class="children reply-block">
            <li class="comment">
                <?php
                foreach ($item->children as $children): ?>
                    <?= $this->render('_comment', ['item' => $children]) ?>
                <?php
                endforeach; ?>
            </li>
        </ul>
    </li>
</ul>

