<?php


/* @var $this \yii\web\View */

/* @var $post \core\entities\Blog\Post\Post */
/* @var $items \frontend\widgets\Blog\CommentView[] */
/* @var $commentForm \core\forms\manage\Blog\CommentForm */

/* @var $count int */


use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

?>


    <div class="pt-5" id="comments">
        <div class="section-title">
            <h2 class="mb-2"><?=Yii::t('blog/comments','Comments')?></h2>
        </div>
        <?php
        foreach ($items as $item): ?>
            <?= $this->render('_comment', ['item' => $item]) ?>
        <?php
        endforeach; ?>
    </div>
    <div class="comment-form-wrap pt-5" >
        <div class="section-title">
            <h2 class="mb-2"><?=Yii::t('blog/comments','Leave a comment')?></h2>
        </div>
        <div class="mt-3" id="reply-block">
            <?php
            $form = ActiveForm::begin(
                [
                    'action' => ['comment', 'id' => $post->id],
                ]
            ); ?>
            <?= Html::activeHiddenInput($commentForm, 'parentId') ?>
            <!--<div class="form-group">
                <label for="name">Name *</label>
                <input type="text" class="form-control" id="name">
            </div>
            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" class="form-control" id="email">
            </div>
            <div class="form-group">
                <label for="website">Website</label>
                <input type="url" class="form-control" id="website">
            </div>-->
            <div class="form-group">
                <?= $form->field($commentForm, 'text')->textarea(
                    ['rows' => 10, 'cols' => '30', 'class' => 'form-control', 'id' => 'message']
                )->label(Yii::t('blog/comments','Message')) ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('blog/comments','Post Comment'), ['class' => 'btn btn-sm btn-primary py-3 btn-shadow btn-gradient']) ?>
            </div>
            <?php
            ActiveForm::end(); ?>
        </div>
    </div>

<?php
$this->registerJs(
    "
    jQuery(document).on('click', '#comments .reply', function () {
        var link = jQuery(this);
        var form = jQuery('#reply-block');
        var comment = link.closest('.comment-list');
        jQuery('#commentform-parentid').val(comment.data('id'));
        form.detach().appendTo(comment.find('.reply-block:first'));
        return false;
    });
"
); ?>