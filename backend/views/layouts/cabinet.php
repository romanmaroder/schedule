<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;

$user = $this->params['user'];
$active ='active';


?>
<?php $this->beginContent('@backend/views/layouts/main.php') ?>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 order-1 order-sm-0">

                    <!-- Profile Image -->
                    <div class="card card-secondary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <?= Html::img(
                                    '@web/img/user1-128x128.jpg',
                                    ['alt' => 'avatar', 'class' => 'profile-user-img img-fluid img-circle img-shadow']
                                ) ?>
                            </div>

                            <h3 class="profile-username text-center"><?= $user->username ?></h3>

                            <p class="text-muted text-center"><?= $user->employee->role->name ?></p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Total entries</b> <span class="float-right badge badge-warning btn-shadow"><?=$this->context->totalCount?></span>
                                </li>
                                <li class="list-group-item">
                                    <b>Today's total entries</b> <span class="float-right badge badge-danger btn-shadow"><?=$this->context->todayCount?></span>
                                </li>
                            </ul>

                            <!--<a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>-->
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    <div class="card card-secondary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">About Me</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fas fa-phone mr-1"></i> Phone</strong>

                            <p class="text-muted">
                                <?= $user->employee->phone ?>
                            </p>

                            <hr>

                            <strong><i class="fas fa-envelope mr-1"></i> Email</strong>

                            <p class="text-muted"><?= $user->email ?></p>

                            <hr>
                            <?
                            if ($user->employee->issetBirthday($user->employee->birthday)): ?>
                                <strong><i class="fas fa-birthday-cake mr-1"></i> Birthday</strong>

                                <p class="text-muted"><?= $user->employee->birthday ?></p>
                                <hr>
                            <?
                            endif; ?>
                            <?
                            if ($user->employee->issetAddress(
                                $user->employee->address->town ||
                                $user->employee->address->borough ||
                                $user->employee->address->street ||
                                $user->employee->address->home ||
                                $user->employee->address->apartment
                            )): ?>
                                <strong><i class="fas fa-map-marker-alt"></i> Address</strong>

                                <p class="text-muted"><?= $user->employee->getFullAddress() ?></p>
                                <hr>
                            <?
                            endif; ?>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- Menu -->
                    <div class="card card-secondary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Menu</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <div class="list-group list-group-flush">
                                <?=Html::a(Html::encode('Events'),Url::to(['/cabinet/default/index']),
                                    ['class' => ['list-group-item',  Yii::$app->controller->route == 'cabinet/default/index' ? 'active': '' ]])?>
                                <?=Html::a(Html::encode('Report'),Url::to(['/cabinet/report/index']),
                                    ['class' => ['list-group-item',  Yii::$app->controller->route == 'cabinet/report/index' ? 'active': '' ]])?>
                                <?=Html::a(Html::encode('Profile'),Url::to(['/cabinet/default/profile']),
                                    ['class' => ['list-group-item',  Yii::$app->controller->route == 'cabinet/default/profile' ? 'active': '' ]])?>
                                <?=Html::a(Html::encode('Timeline'),Url::to(['/cabinet/default/timeline']),
                                    ['class' => ['list-group-item',  Yii::$app->controller->route == 'cabinet/default/timeline' ? 'active': '' ]])?>

                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card card-secondary card-outline">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <?=Html::a(Html::encode('Events'),Url::to(['/cabinet/default/index']),
                                     ['class' => ['nav-link btn-sm',  Yii::$app->controller->route == 'cabinet/default/index' ? 'active btn-shadow': '' ]])?>
                                </li>
                                <li class="nav-item">
                                    <?=Html::a(Html::encode('Timeline'),Url::to(['/cabinet/default/timeline']),
                                               ['class' => ['nav-link btn-sm',  Yii::$app->controller->route == 'cabinet/default/timeline' ? 'active btn-shadow': '' ]])?>
                                </li>
                                <li class="nav-item">
                                    <?=Html::a(Html::encode('Profile'),Url::to(['/cabinet/default/profile']),
                                        ['class' => ['nav-link btn-sm',  Yii::$app->controller->route == 'cabinet/default/profile' ? 'active btn-shadow': '' ]])?>

                                </li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <?= $content; ?>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

<?php $this->endContent() ?>