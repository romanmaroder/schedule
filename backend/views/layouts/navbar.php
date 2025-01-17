<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <?php
        echo Html::tag(
            'li',
            Html::a(
                Yii::t('navbar','Home'),
                 Url::home(),
                ['class' => ['nav-link',  Yii::$app->controller->id == 'site' ? 'active': '' ]]
            ),
            ['class' => ['nav-item d-none d-sm-inline-block']]
        ); ?>
        <?php
        echo Html::tag(
            'li',
            Html::a(
                Yii::t('navbar','Calendar'),
                ['/schedule/calendar/calendar'],
                ['class' => ['nav-link',  Yii::$app->controller->id == 'schedule/calendar' ? 'active': '' ]]
            ),
            ['class' => ['nav-item d-none d-sm-inline-block']]
        ); ?>
        <?php
        echo Html::tag(
            'li',
            Html::a(
                Yii::t('navbar','graph'),
               'https://shiftcalendar.online/ru',
                ['class' => ['nav-link'],'target' => '_blank']
            ),
            ['class' => ['nav-item d-none d-sm-inline-block']]
        ); ?>
        <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><?=Yii::t('navbar','Dropdown')?></a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                <?php
                echo Html::tag(
                    'li',
                    Html::a(
                        Yii::t('navbar','Calendar'),
                        ['/schedule/calendar/calendar'],
                        ['class' => ['dropdown-item',  Yii::$app->controller->id == 'schedule/calendar' ? 'active': '' ]]
                    ),
                    ['class' => ['d-sm-none']]
                ); ?>
                <?php
                echo Html::tag(
                    'li',
                    Html::a(
                        Yii::t('navbar','graph'),
                        'https://shiftcalendar.online/ru',
                        ['class' => ['dropdown-item'],'target' => '_blank']
                    ),
                    ['class' => ['d-sm-none']]
                ); ?>
                <!-- Level two dropdown-->
                <li class="dropdown-submenu dropdown-hover">
                    <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false"
                       class="dropdown-item dropdown-toggle"><?=Yii::t('navbar','Account')?></a>
                    <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                        <?php
                        echo Html::tag(
                            'li',
                            Html::a(
                                Yii::t('navbar','Cabinet'),
                                ['/cabinet/default/index'],
                                ['class' => ['dropdown-item', Yii::$app->controller->id == 'cabinet/default' ? 'active': ''],
                                'tabindex'=>'-1']
                            ),
                            ['class' => ['d-block']]
                        ); ?>
                        <?php
                        echo Html::tag(
                            'li',
                            Html::a(
                                Yii::t('navbar','Report'),
                                ['/cabinet/report/report'],
                                ['class' => ['dropdown-item',  Yii::$app->controller->route == 'cabinet/report/report' ? 'active': '' ]]
                            ),
                            ['class' => ['d-block']]
                        ); ?>
                        <?php
                        echo Html::tag(
                            'li',
                            Html::a(
                                Yii::t('navbar','Salary'),
                                ['/cabinet/report/index'],
                                ['class' => ['dropdown-item',  Yii::$app->controller->route == 'cabinet/report/index' ? 'active': '' ]]
                            ),
                            ['class' => ['d-block']]
                        ); ?>
                        <?php
                        echo Html::tag(
                            'li',
                            Html::a(
                                Yii::t('navbar','Unpaid'),
                                ['/cabinet/report/unpaid'],
                                ['class' => ['dropdown-item',  Yii::$app->controller->route == 'cabinet/report/unpaid' ? 'active': '' ]]
                            ),
                            ['class' => ['d-block']]
                        ); ?>
                        <?php
                        echo Html::tag(
                            'li',
                            Html::a(
                                Yii::t('navbar','Expenses'),
                                ['/cabinet/report/expenses'],
                                ['class' => ['dropdown-item',  Yii::$app->controller->route == 'cabinet/report/expenses' ? 'active': '' ]]
                            ),
                            ['class' => ['d-block']]
                        ); ?>
                        <?php
                        echo Html::tag(
                            'li',
                            Html::a(
                                Yii::t('navbar','Summary Report'),
                                ['/cabinet/report/summary-report'],
                                ['class' => ['dropdown-item',  Yii::$app->controller->route == 'cabinet/report/summary-report' ? 'active': '' ]]
                            ),
                            ['class' => ['d-block']]
                        ); ?>
                        <?php
                        echo Html::tag(
                            'li',
                            Html::a(
                                Yii::t('navbar','Payment'),
                                ['/cabinet/report/payment'],
                                ['class' => ['dropdown-item',  Yii::$app->controller->route == 'cabinet/report/payment' ? 'active': '' ]]
                            ),
                            ['class' => ['d-block']]
                        ); ?>
                    </ul>
                </li>
                <li class="dropdown-divider"></li>
                <li><?= Html::a(Yii::t('navbar','Sign out'), ['/auth/logout'], ['data-method' => 'post', 'class' => 'dropdown-item']) ?></li>
                <!-- End Level two -->
            </ul>
        </li>
    </ul>

    <!-- SEARCH FORM -->
    <!--<form class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>-->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <!--<li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>-->

        <!-- Messages Dropdown Menu -->
        <!--<li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-comments"></i>
                <span class="badge badge-danger navbar-badge">3</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="#" class="dropdown-item">-->
                    <!-- Message Start -->
                    <!--<div class="media">
                        <img src="<?php
                    /*=$assetDir*/?>/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Brad Diesel
                                <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">Call me whenever you can...</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>-->
                    <!-- Message End -->
                <!--</a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">-->
                    <!-- Message Start -->
                    <!--<div class="media">
                        <img src="<?php
                    /*=$assetDir*/?>/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                John Pierce
                                <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">I got your message bro</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>-->
                    <!-- Message End -->
                <!--</a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">-->
                    <!-- Message Start -->
                    <!--<div class="media">
                        <img src="<?php
                    /*=$assetDir*/?>/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Nora Silvester
                                <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">The subject goes here</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>-->
                    <!-- Message End -->
                <!--</a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
            </div>
        </li>-->
        <!-- Notifications Dropdown Menu -->
        <!--<li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">15</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> 4 new messages
                    <span class="float-right text-muted text-sm">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> 8 friend requests
                    <span class="float-right text-muted text-sm">12 hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-file mr-2"></i> 3 new reports
                    <span class="float-right text-muted text-sm">2 days</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>-->
        <li class="nav-item">
            <?= Html::a('<i class="fas fa-sign-out-alt"></i>', ['/auth/logout'], ['data-method' => 'post', 'class' => 'nav-link','alt'=>'logout']) ?>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->