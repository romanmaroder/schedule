<?php


/* @var $this \yii\web\View */

/* @var $searchModel \backend\forms\UserSearch */

/* @var $dataProvider \yii\data\ActiveDataProvider */


use core\helpers\ScheduleHelper;
use core\helpers\UserHelper;
use yii\helpers\Html;
use yii\widgets\LinkPager;


$this->title = Yii::t('user/user','Users');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php if ($dataProvider->getModels() != null) :?>
<!-- Default box -->
<div class="card card-solid">
    <div class="card-header">
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="maximize" title="Maximize">
                <i class="fas fa-expand"></i>
            </button>
        </div>
    </div>
    <div class="card-body pb-0">
        <div class="row">
            <?php
            foreach ($dataProvider->getModels() as $user) :?>
                <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                    <div class="card bg-light d-flex flex-fill">
                        <div class="card-header text-muted border-bottom-0"></div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="lead mb-3"><b><?= $user->username ?></b></h2>

                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                        <?php
                                        if ($user->status): ?>
                                            <li class="mb-2">
                                                <span class="fa-li"><i class="fas fa-shield-alt"></i></span>
                                                <?= UserHelper::statusLabel($user->status) ?>
                                            </li>
                                        <?php
                                        endif; ?>

                                        <?php
                                        if ($user->phone): ?>
                                            <li class="mb-2">
                                                <span class="fa-li"><i class="fas fa-phone"></i></span>
                                                <a href="tel:<?= $user->phone; ?>"> <?= $user->phone; ?></a>
                                            </li>
                                        <?php
                                        endif; ?>
                                        <?php
                                        if ($user->email): ?>
                                                <li class="mb-2">
                                                    <span class="fa-li"><i class="fas fa-envelope"></i></span>
                                                    <a href="mailto:<?= $user->email; ?>"><?= $user->email; ?></a>
                                                </li>
                                        <?php
                                        endif; ?>
                                        <?php
                                            if ($user->schedule->week): ?>
                                                <li class="mb-2">
                                                    <span class="fa-li"><i class="fas fa-calendar-week"></i></span>
                                                    Week :
                                                    <span><?=  $user->schedule->week; ?></span>
                                                </li>
                                            <?php
                                            endif; ?>
                                        <?php
                                            if ($user->schedule->weekends): ?>
                                                <li class="mb-2">
                                                    <span class="fa-li"><i class="fas fa-calendar-alt"></i></span>
                                                    Days :
                                                    <span><?= ScheduleHelper::getWeekends(
                                                            $user->schedule->weekends
                                                        ); ?></span>
                                                </li>
                                            <?php
                                            endif; ?>
                                        <?php
                                            if ($user->schedule->hoursWork): ?>
                                                <li class="mb-2">
                                                    <span class="fa-li"><i class="fas fa-clock"></i></span>
                                                    Hours:
                                                    <span><?= ScheduleHelper::getWorkingHours(
                                                            $user->schedule->hoursWork
                                                        ); ?></span>
                                                </li>
                                            <?php
                                            endif; ?>
                                        <?php
                                            if ($user->notice): ?>
                                                <li class="mb-2">
                                                    <span class="fa-li"><i class="fas fa-comment-alt"></i></span>
                                                    Notice :
                                                    <span><?= $user->notice; ?></span>
                                                </li>
                                            <?php
                                            endif; ?>
                                        </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-right">
                                <!--<a href="#" class="btn btn-sm bg-teal">
                                    <i class="fas fa-comments"></i>
                                </a>-->
                                <?= Html::a(
                                    '<i class="fas fa-user"></i>  ' . Yii::t('app','Profile'),
                                    ['user/view', 'id' => $user->id],
                                    ['class' => 'btn btn-sm btn-primary']
                                ) ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            endforeach; ?>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <nav aria-label="Contacts Page Navigation">
            <?= LinkPager::widget(
                [
                    'pagination' => $dataProvider->getPagination(),
                    'options'=>[
                        'class'=>'pagination justify-content-center m-0'
                    ],
                    'linkOptions' => [
                        'class' => 'page-link',
                    ],
                    'linkContainerOptions' => [
                        'class' => 'page-item'
                    ],
                    'prevPageCssClass' => 'page-item',
                    'nextPageCssClass' => 'page-item',
                    'prevPageLabel' => '<span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>',
                    'nextPageLabel' => '<span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>',
                    'hideOnSinglePage' => true,
                    'disabledListItemSubTagOptions'=>[
                        'tag'=>'a',
                        'class'=>'page-link'
                    ],
                    'maxButtonCount'=>5

                ]
            ) ?>
        </nav>
    </div>
    <!-- /.card-footer -->
</div>
<!-- /.card -->

<?php endif; ?>