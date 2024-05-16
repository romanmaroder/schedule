<?php

/* @var $this yii\web\View */

/* @var $post schedule\entities\Blog\Post\Post */

use yii\helpers\Html;

//$this->title = $post->getSeoTitle();
$this->title = $post->title;

$this->registerMetaTag(['name' => 'description', 'content' => $post->meta->description]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $post->meta->keywords]);

$this->params['breadcrumbs'][] = ['label' => 'Blog', 'url' => ['index']];
$this->params['breadcrumbs'][] = [
    'label' => $post->category->name,
    'url' => ['category', 'slug' => $post->category->slug]
];
$this->params['breadcrumbs'][] = $post->title;

$this->params['active_category'] = $post->category;

$tagLinks = [];
foreach ($post->tags as $tag) {
    $tagLinks[] = Html::a(Html::encode($tag->name), ['tag', 'slug' => $tag->slug]);
}
?>


<p class="mb-5">
    <?php
    if ($post->files): ?>
        <img src="<?= Html::encode($post->getThumbFileUrl('files', 'origin')) ?>" alt="Image1" class="img-fluid"/>
    <?php
    endif; ?>
</p>
<h1 class="mb-4">
    <?= Html::encode($post->title) ?>
</h1>
<div class="post-meta d-flex mb-5">
    <div class="bio-pic mr-3">
        <?php
        if ($post->files): ?>
            <img src="<?= Html::encode($post->getThumbFileUrl('files', 'blog_list')) ?>" alt="Image"
                 class="img-fluidid"/>
        <?php
        endif; ?>
    </div>
    <div class="vcard">
        <span class="d-block"><a href="#">Education</a></span>
        <span class="date-read"><i class="far fa-calendar-alt"></i> <?= Yii::$app->formatter->asDatetime(
                $post->created_at
            ); ?></span>
    </div>
</div>
<p><?= Yii::$app->formatter->asNtext($post->content) ?></p>
<div class="pt-5">
    <p>Categories: <a href="#"><?= $post->category->name ?></a> Tags: <a href="#">#<?= implode(', ', $tagLinks) ?></a>
    </p>
</div>
<div class="pt-5">
    <div class="section-title">
        <h2 class="mb-5">6 Comments</h2>
    </div>
    <ul class="comment-list">
        <li class="comment">
            <div class="vcard bio">
                <img src="images/person_1.jpg" alt="Image placeholder">
            </div>
            <div class="comment-body">
                <h3>Jean Doe</h3>
                <div class="meta">January 9, 2018 at 2:21pm</div>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur quidem laborum necessitatibus,
                    ipsam impedit vitae autem, eum officia, fugiat saepe enim sapiente iste iure! Quam voluptas earum
                    impedit necessitatibus, nihil?</p>
                <p><a href="#" class="reply">Reply</a></p>
            </div>
        </li>
        <li class="comment">
            <div class="vcard bio">
                <img src="images/person_1.jpg" alt="Image placeholder">
            </div>
            <div class="comment-body">
                <h3>Jean Doe</h3>
                <div class="meta">January 9, 2018 at 2:21pm</div>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur quidem laborum necessitatibus,
                    ipsam impedit vitae autem, eum officia, fugiat saepe enim sapiente iste iure! Quam voluptas earum
                    impedit necessitatibus, nihil?</p>
                <p><a href="#" class="reply">Reply</a></p>
            </div>
            <ul class="children">
                <li class="comment">
                    <div class="vcard bio">
                        <img src="images/person_1.jpg" alt="Image placeholder">
                    </div>
                    <div class="comment-body">
                        <h3>Jean Doe</h3>
                        <div class="meta">January 9, 2018 at 2:21pm</div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur quidem laborum
                            necessitatibus, ipsam impedit vitae autem, eum officia, fugiat saepe enim sapiente iste
                            iure! Quam voluptas earum impedit necessitatibus, nihil?</p>
                        <p><a href="#" class="reply">Reply</a></p>
                    </div>
                    <ul class="children">
                        <li class="comment">
                            <div class="vcard bio">
                                <img src="images/person_1.jpg" alt="Image placeholder">
                            </div>
                            <div class="comment-body">
                                <h3>Jean Doe</h3>
                                <div class="meta">January 9, 2018 at 2:21pm</div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur quidem laborum
                                    necessitatibus, ipsam impedit vitae autem, eum officia, fugiat saepe enim sapiente
                                    iste iure! Quam voluptas earum impedit necessitatibus, nihil?</p>
                                <p><a href="#" class="reply">Reply</a></p>
                            </div>
                            <ul class="children">
                                <li class="comment">
                                    <div class="vcard bio">
                                        <img src="images/person_1.jpg" alt="Image placeholder">
                                    </div>
                                    <div class="comment-body">
                                        <h3>Jean Doe</h3>
                                        <div class="meta">January 9, 2018 at 2:21pm</div>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur quidem
                                            laborum necessitatibus, ipsam impedit vitae autem, eum officia, fugiat saepe
                                            enim sapiente iste iure! Quam voluptas earum impedit necessitatibus,
                                            nihil?</p>
                                        <p><a href="#" class="reply">Reply</a></p>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="comment">
            <div class="vcard bio">
                <img src="images/person_1.jpg" alt="Image placeholder">
            </div>
            <div class="comment-body">
                <h3>Jean Doe</h3>
                <div class="meta">January 9, 2018 at 2:21pm</div>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur quidem laborum necessitatibus,
                    ipsam impedit vitae autem, eum officia, fugiat saepe enim sapiente iste iure! Quam voluptas earum
                    impedit necessitatibus, nihil?</p>
                <p><a href="#" class="reply">Reply</a></p>
            </div>
        </li>
    </ul>

    <div class="comment-form-wrap pt-5">
        <div class="section-title">
            <h2 class="mb-5">Leave a comment</h2>
        </div>
        <form action="#" class="p-5 bg-light">
            <div class="form-group">
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
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea name="" id="message" cols="30" rows="10" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <input type="submit" value="Post Comment" class="btn btn-primary py-3">
            </div>
        </form>
    </div>
</div>

