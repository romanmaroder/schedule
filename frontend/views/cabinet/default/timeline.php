<?php


/* @var $this \yii\web\View */

/* @var $employee \schedule\entities\User\Employee\Employee */

/* @var $user \schedule\entities\User\User */

/* @var $events \schedule\entities\Schedule\Event\Event */

/* @var $model \schedule\forms\manage\User\Employee\EmployeeEditForm */

/* @var $educations \schedule\entities\Schedule\Event\Education */


use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Timeline';
$this->params['breadcrumbs'][] = $this->title;
$this->params['user'] = $user;

$emptyEvents = 'recordings';
$emptyEducations = 'lesson';
?>

<div class="active tab-pane" id="timeline">
    <div class="timeline timeline-inverse">
        <div class="time-label">
            <span class="bg-danger btn-shadow"><?=date('d-M-Y')?></span>
        </div>
        <? if (!$events && !$educations):?>
            <div>
                <i class="fas fa-exclamation-circle bg-warning btn-shadow"></i>

                <div class="timeline-item btn-shadow">
                    <span class="time"><i class="far fa-clock"></i><?=date('H:i')?></span>

                    <h3 class="timeline-header"><a href="#">Warning</a>
                    </h3>

                    <div class="timeline-body">
                        You have no <?= !$events ? $emptyEvents : $emptyEducations?> today
                    </div>
                </div>
            </div>
        <?endif;?>
        <? foreach($events as $event) :?>
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
        <?endforeach;?>

        <? foreach($educations as $education) :?>

            <div>
                <i class="fas fa-comments bg-warning btn-shadow"></i>

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

        <?endforeach;?>
        <div>
            <i class="far fa-clock bg-gray btn-shadow"></i>
        </div>
    </div>

</div>
