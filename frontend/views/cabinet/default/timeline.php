<?php


/* @var $this \yii\web\View */

/* @var $employee \core\entities\User\Employee\Employee */

/* @var $events \core\entities\Schedule\Event\Event */

/* @var $free \core\entities\Schedule\Event\FreeTime */

/* @var $model \core\forms\manage\User\Employee\EmployeeEditForm */

/* @var $educations \core\entities\Schedule\Event\Education*/


use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('cabinet','Timeline');
$this->params['breadcrumbs'][] = $this->title;

$emptyEvents = Yii::t('cabinet/error','recordings');
$emptyEducations = Yii::t('cabinet/error','lesson');

?>
<div class="active tab-pane" id="timeline">
    <div class="timeline timeline-inverse">
        <div class="time-label">
            <span class="bg-danger btn-shadow">
                <?=\Yii::$app->formatter->asDate(date('d-M-Y'),'medium')?>
            </span>
        </div>
        <?php
        if (!$events && !$educations && !$free):?>
            <div>
                <i class="fas fa-exclamation-circle bg-warning btn-shadow"></i>

                <div class="timeline-item btn-shadow">
                    <span class="time">
                        <i class="far fa-clock"></i>
                        <?=\Yii::$app->formatter->asTime(date('H:i'),'short')?>
                    </span>

                    <h3 class="timeline-header"><a href="#"><?=Yii::t('cabinet/error','Warning')?></a>
                    </h3>

                    <div class="timeline-body">
                        <?=Yii::t('cabinet/error','You have no')?> <?= !$events ? $emptyEvents : $emptyEducations?>
                        <?=Yii::t('cabinet/error','today')?>
                    </div>
                </div>
            </div>
        <?php
        endif;?>
        <?php
        foreach($events as $event) :?>
            <div>
                <i class="fas fa-user bg-info btn-shadow"></i>

                <div class="timeline-item btn-shadow">
                <span class="time"><i class="far fa-clock"></i>
                    <?= date('H:i',strtotime($event->start))?>-<?= date('H:i',strtotime($event->end))?>
                </span>

                    <h3 class="timeline-header border-0">
                        <?= Html::a(Html::encode($event->client->username),Url::toRoute(['user/view','id'=>$event->client->id]))?>
                        <span class="d-block"><?=implode(', ', ArrayHelper::getColumn($event->services, 'name'))?></span>
                    </h3>

                </div>
            </div>
        <?php
        endforeach;?>

        <?php
        foreach($free as $item) :?>
            <div>
                <i class="fas fa-umbrella-beach  bg-info btn-shadow"></i>

                <div class="timeline-item btn-shadow">
                <span class="time"><i class="far fa-clock"></i>
                    <?= date('H:i',strtotime($item->start))?>-<?= date('H:i',strtotime($item->end))?>
                </span>

                    <h3 class="timeline-header border-0">
                        <?= Html::a(Html::encode($item->master->username),Url::toRoute(['user/view','id'=>$item->master->id]))?>
                        <span class="d-block"><?=$item->additional->name?></span>
                    </h3>

                </div>
            </div>
        <?php
        endforeach;?>

        <?php
        foreach($educations as $education) :?>

            <div>
                <i class="fas fa-graduation-cap bg-warning btn-shadow"></i>
                <div class="timeline-item btn-shadow">
                    <span class="time"><i class="far fa-clock"></i>
                        <?= date('H:i',strtotime($education->start))?>-<?= date('H:i',strtotime($education->end))?>
                    </span>

                    <h3 class="timeline-header"> <?= Html::a(Html::encode($education->teacher->username),Url::toRoute(['user/view','id'=>$education->teacher->id]))?>
                        <span class="text-success ml-3"><?=$education->title?></span>
                    </h3>

                    <div class="timeline-body">
                        <?=$education->description?>
                    </div>

                </div>
            </div>

        <?php
        endforeach;?>
        <div>
            <i class="far fa-clock bg-gray btn-shadow"></i>
        </div>
    </div>

</div>
