<?php

use yii\helpers\Html;

?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="<?= $assetDir ?>/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <!--<img src="<?/*= $assetDir */?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">-->
                <p class="img-circle elevation-2"><?=Yii::$app->user->identity->getInitials()?></p>
            </div>
            <div class="info">
                <?=
                Html::a(
                    Yii::$app->user->identity->username ?? '' ,
                    ['/cabinet/default/index'],
                    ['class' => ['d-block']]
                ); ?>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <!-- href be escaped -->
        <!-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            echo \hail812\adminlte\widgets\Menu::widget(
                [
                    'items' => [
                        [
                            'label' => 'Management',
                            'icon' => 'tachometer-alt',
                            'badge' => '<span class="right badge badge-info">2</span>',
                            'options' => ['class' => 'header'],
                            'items' => [
                                //['label' => 'Active Page', 'url' => ['site/index'], 'iconStyle' => 'far'],
                                //['label' => 'Inactive Page', 'iconStyle' => 'far'],
                                [
                                    'label' => 'Schedule',
                                    'icon' => 'folder',
                                    'items' => [
                                        [
                                            'label' => 'Products',
                                            'icon' => 'fas fa-parking',
                                            'url' => ['/schedule/product/index'],
                                            'active' => $this->context->id == 'schedule/product'
                                        ],
                                        [
                                            'label' => 'Service',
                                            'icon' => 'fas fa-clipboard-list',
                                            'url' => ['/schedule/service/index'],
                                            'active' => $this->context->id == 'schedule/service'
                                        ],
                                        [
                                            'label' => 'Events',
                                            'icon' => 'far fa-file-alt',
                                            'url' => ['/schedule/event/index'],
                                            'active' => $this->context->id == 'schedule/event'
                                        ],
                                        [
                                            'label' => 'Education',
                                            'icon' => 'fas fa-graduation-cap',
                                            'url' => ['/schedule/education/index'],
                                            'active' => $this->context->id == 'schedule/education'
                                        ],
                                        [
                                            'label' => 'Calendar',
                                            'icon' => 'far fa-calendar-alt',
                                            'url' => ['/schedule/calendar/calendar'],
                                            'active' => $this->context->id == 'schedule/calendar'
                                        ],
                                        [
                                            'label' => 'Brands',
                                            'icon' => 'fa-solid fa-copyright',
                                            'url' => ['/schedule/brand/index'],
                                            'active' => $this->context->id == 'schedule/brand'
                                        ],
                                        [
                                            'label' => 'Tags',
                                            'icon' => 'fa-solid fa-tags',
                                            'url' => ['/schedule/tag/index'],
                                            'active' => $this->context->id == 'schedule/tag'
                                        ],
                                        [
                                            'label' => 'Categories',
                                            'icon' => 'fa-solid fa-list',
                                            'url' => ['/schedule/category/index'],
                                            'active' => $this->context->id == 'schedule/category'
                                        ],
                                        [
                                            'label' => 'Characteristics',
                                            'icon' => 'fas fa-thermometer-quarter',
                                            'url' => ['/schedule/characteristic/index'],
                                            'active' => $this->context->id == 'schedule/characteristic'
                                        ],
                                    ]
                                ],
                                [
                                    'label' => 'Users Management',
                                    'icon' => 'fas fa-users-cog',
                                    'items'=>[
                                        [
                                            'label' => 'Users',
                                            'icon' => 'fas fa-users',
                                            'url' => ['/user/index'],
                                            'active' => $this->context->id == 'user'
                                        ],
                                        [
                                            'label' => 'Employee',
                                            'icon' => 'fas fa-user-tie',
                                            'url' => ['/employee/index'],
                                            'active' => $this->context->id == 'employee'
                                        ],
                                        [
                                            'label' => 'Role',
                                            'icon' => 'fas fa-user-tag',
                                            'url' => ['/role/index'],
                                            'active' => $this->context->id == 'role'
                                        ],
                                        [
                                            'label' => 'Rate',
                                            'icon' => 'fas fa-percent',
                                            'url' => ['/rate/index'],
                                            'active' => $this->context->id == 'rate'
                                        ],
                                        [
                                            'label' => 'Price',
                                            'icon' => 'fas fa-money-check-alt',
                                            'url' => ['/price/index'],
                                            'active' => $this->context->id == 'price'
                                        ],
                                    ]
                                ],

                            ]
                        ],
                        //['label' => 'Simple Link', 'icon' => 'th', 'badge' => '<span class="right badge badge-danger">New</span>'],
                        ['label' => 'Yii2 PROVIDED', 'header' => true],
                        [
                            'label' => 'Login',
                            'url' => ['site/login'],
                            'icon' => 'sign-in-alt',
                            'visible' => Yii::$app->user->isGuest
                        ],
                        ['label' => 'Gii', 'icon' => 'file-code', 'url' => ['/gii'], 'target' => '_blank'],
                        ['label' => 'Debug', 'icon' => 'bug', 'url' => ['/debug'], 'target' => '_blank'],
//                    ['label' => 'MULTI LEVEL EXAMPLE', 'header' => true],
//                    ['label' => 'Level1'],
//                    [
//                        'label' => 'Level1',
//                        'items' => [
//                            ['label' => 'Level2', 'iconStyle' => 'far'],
//                            [
//                                'label' => 'Level2',
//                                'iconStyle' => 'far',
//                                'items' => [
//                                    ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle'],
//                                    ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle'],
//                                    ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle']
//                                ]
//                            ],
//                            ['label' => 'Level2', 'iconStyle' => 'far']
//                        ]
//                    ],
//                    ['label' => 'Level1'],
//                    ['label' => 'LABELS', 'header' => true],
//                    ['label' => 'Important', 'iconStyle' => 'far', 'iconClassAdded' => 'text-danger'],
//                    ['label' => 'Warning', 'iconClass' => 'nav-icon far fa-circle text-warning'],
//                    ['label' => 'Informational', 'iconStyle' => 'far', 'iconClassAdded' => 'text-info'],
                    ],
                ]
            );
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>