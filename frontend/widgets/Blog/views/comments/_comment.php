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
            <?= Html::img(Url::to('/img/logo.jpg')) ?>
        </div>
        <div class="comment-body">
            <h3><?= $item->comment->employee->getFullName() ?></h3>
            <div class="meta"><?= Yii::$app->formatter->asDatetime($item->comment->created_at) ?></div>
            <p><?php
                if ($item->comment->isActive()): ?>
                    <?= Yii::$app->formatter->asNtext($item->comment->text) ?>
                <?php
                else: ?>
                    <i>Comment is deleted.</i>
                <?php
                endif; ?></p>
            <p><a href="#" class="reply btn-shadow">Reply</a></p>
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

