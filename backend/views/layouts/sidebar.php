<?php

use yii\helpers\Html;

/** @var $user \core\entities\User\User*/


?>
<?php if (Yii::$app->id ==='app-backend'):?>
<?php $user = \core\entities\User\User::findOne(Yii::$app->user->identity->getId());?>
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
                <p class="img-circle elevation-2"><?=$user->getInitials()?></p>
            </div>
            <div class="info">
                <?=
                Html::a(
                    $user->username ?? '' ,
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
                    'options' => [
                        'class' => 'nav nav-pills nav-sidebar flex-column nav-child-indent',
                        'data-widget' => 'treeview',
                        'role' => 'menu',
                        'data-accordion' => 'false'
                    ],
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
                                    'icon' => 'fas fa-folder-plus',
                                    'items' => [
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
                                            'label' => 'Missed user',
                                            'icon' => 'fas fa-user-clock',
                                            'url' => ['/schedule/missing-users/index'],
                                            'active' => $this->context->id == 'schedule/missing-users'
                                        ],
                                        [
                                            'label' => 'Service',
                                            'icon' => 'fas fa-hand-spock',
                                            'items' => [
                                                [
                                                    'label' => 'Service',
                                                    'icon' => 'fas fa-clipboard-list',
                                                    'url' => ['/schedule/service/index'],
                                                    'active' => $this->context->id == 'schedule/service'
                                                ],
                                                [
                                                    'label' => 'Categories',
                                                    'icon' => 'fa-solid fa-list',
                                                    'url' => ['/schedule/category/index'],
                                                    'active' => $this->context->id == 'schedule/category'
                                                ],
                                                [
                                                    'label' => 'Tags',
                                                    'icon' => 'fa-solid fa-tags',
                                                    'url' => ['/schedule/tag/index'],
                                                    'active' => $this->context->id == 'expenses/tag'
                                                ],
                                            ]
                                        ],
                                        [
                                            'label' => 'Additional',
                                            'icon' => 'fas fa-suitcase-rolling',
                                            'items' => [
                                                [
                                                    'label' => 'Additional',
                                                    'icon' => 'fas fa-subway',
                                                    'url' => ['/schedule/additional/index'],
                                                    'active' => $this->context->id == 'schedule/additional'
                                                ],
                                                [
                                                    'label' => 'Categories',
                                                    'icon' => 'fa-solid fa-list',
                                                    'url' => ['/schedule/additional-category/index'],
                                                    'active' => $this->context->id == 'schedule/additional-category'
                                                ],

                                            ]
                                        ],
                                    ]
                                ],
                                [
                                    'label' => 'Shop',
                                    'icon' => 'fas fa-folder-plus',
                                    'items' => [
                                        [
                                            'label' => 'Products',
                                            'icon' => 'fas fa-parking',
                                            'url' => ['/shop/product/index'],
                                            'active' => $this->context->id == 'shop/product'
                                        ],
                                        [
                                            'label' => 'Categories',
                                            'icon' => 'fa-solid fa-list',
                                            'url' => ['/shop/category/index'],
                                            'active' => $this->context->id == 'shop/category'
                                        ],
                                        [
                                            'label' => 'Brands',
                                            'icon' => 'fa-solid fa-copyright',
                                            'url' => ['/shop/brand/index'],
                                            'active' => $this->context->id == 'shop/brand'
                                        ],
                                        [
                                            'label' => 'Tags',
                                            'icon' => 'fa-solid fa-tags',
                                            'url' => ['/shop/tag/index'],
                                            'active' => $this->context->id == 'shop/tag'
                                        ],
                                        [
                                            'label' => 'Characteristics',
                                            'icon' => 'fas fa-thermometer-quarter',
                                            'url' => ['/shop/characteristic/index'],
                                            'active' => $this->context->id == 'shop/characteristic'
                                        ],
                                        [
                                            'label' => 'Delivery Methods',
                                            'icon' => 'fas fa-truck',
                                            'url' => ['/shop/delivery/index'],
                                            'active' => $this->context->id == 'shop/delivery'
                                        ],
                                        [
                                            'label' => 'Orders',
                                            'icon' => 'fas fa-barcode',
                                            'url' => ['/shop/order/index'],
                                            'active' => $this->context->id == 'shop/order'
                                        ],
                                        [
                                            'label' => 'Reviews',
                                            'icon' => 'fas fa-comment-alt',
                                            'url' => ['/shop/review/index'],
                                            'active' => $this->context->id == 'shop/review'
                                        ],
                                    ]
                                ],
                                [
                                    'label' => 'Expense',
                                    'icon' => 'fas fa-balance-scale',
                                    'items' => [
                                        [
                                            'label' => 'Expense',
                                            'icon' => 'fas fa-clipboard-list',
                                            'url' => ['/expenses/expense/index'],
                                            'active' => $this->context->id == 'expenses/expense'
                                        ],
                                        [
                                            'label' => 'Categories',
                                            'icon' => 'fas fa-clipboard-list',
                                            'url' => ['/expenses/category/index'],
                                            'active' => $this->context->id == 'expenses/category'
                                        ],
                                        [
                                            'label' => 'Tags',
                                            'icon' => 'fa-solid fa-tags',
                                            'url' => ['/expenses/tag/index'],
                                            'active' => $this->context->id == 'expenses/tag'
                                        ],
                                    ]
                                ],
                                [
                                    'label' => 'Users',
                                    'icon' => 'fas fa-users-cog',
                                    'items' => [
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
                                [
                                    'label' => 'Blog',
                                    'icon' => 'fas fa-blog',
                                    'items' => [
                                        [
                                            'label' => 'Posts',
                                            'icon' => 'fas fa-keyboard',
                                            'url' => ['/blog/post/index'],
                                            'active' => $this->context->id == 'blog/post'
                                        ],
                                        [
                                            'label' => 'Tags',
                                            'icon' => 'fa-solid fa-tags',
                                            'url' => ['/blog/tag/index'],
                                            'active' => $this->context->id == 'blog/tag'
                                        ],
                                        [
                                            'label' => 'Categories',
                                            'icon' => 'fas fa-clipboard-list',
                                            'url' => ['/blog/category/index'],
                                            'active' => $this->context->id == 'blog/category'
                                        ],
                                        [
                                            'label' => 'Comments',
                                            'icon' => 'fas fa-comments',
                                            'url' => ['/blog/comment/index'],
                                            'active' => $this->context->id == 'blog/comment'
                                        ],
                                    ]
                                ],
                                [
                                    'label' => 'Content',
                                    'icon' => 'far fa-file-alt',
                                    'items' => [
                                        [
                                            'label' => 'Pages',
                                            'icon' => 'fas fa-file-word',
                                            'url' => ['/page/index'],
                                            'active' => $this->context->id == 'page'
                                        ],
                                        [
                                            'label' => 'Files',
                                            'icon' => 'fas fa-file-upload',
                                            'url' => ['/file/index'],
                                            'active' => $this->context->id == 'file'
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
<?php endif;?>