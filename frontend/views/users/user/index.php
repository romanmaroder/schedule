<?php


/* @var $this \yii\web\View */

/* @var $searchModel \backend\forms\UserSearch */

/* @var $dataProvider \yii\data\ActiveDataProvider */


use yii\widgets\LinkPager;


$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- Default box -->
<div class="card card-solid">
    <div class="card-header">
        <!--<h3 class="card-title">
            <?/*= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) */?>
        </h3>-->

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
                        <div class="card-header text-muted border-bottom-0">
                            Digital Strategist // TODO Identify the role
                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="lead"><b><?= $user->username ?></b>
                                    <p class="text-muted text-sm"><b>About: </b> Web Designer / UX / Graphic Artist /
                                        Coffee Lover </p>
                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                        <li class="small mb-2">
                                            <span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Address:
                                            Demo Street 123, Demo City 04312, NJ
                                        </li>
                                        <li class="small mb-2">
                                            <span class="fa-li"><i class="fas fa-lg fa-phone"></i></span>
                                            <a href="tel:+80012122352"> Phone #: + 800 - 12 12 23 52</a></li>
                                        <li class="small">
                                            <span class="fa-li"><i class="fas fa-lg fa-envelope"></i></span>
                                            <a href="mailto:<?= $user->email; ?>"><?= $user->email; ?></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-right">
                                <a href="#" class="btn btn-sm bg-teal">
                                    <i class="fas fa-comments"></i>
                                </a>
                                <a href="#" class="btn btn-sm btn-primary">
                                    <i class="fas fa-user"></i> View Profile
                                </a>
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
                    'options'=>[
                        'class'=>'pagination justify-content-center m-0'
                    ],
                    'maxButtonCount'=>1,
                    'linkContainerOptions'=>[
                        'class'=>'page-item'
                    ],
                    'pagination' => $dataProvider->getPagination(),
                ]
            ) ?>
            <!--<ul class="pagination justify-content-center m-0">
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">4</a></li>
                <li class="page-item"><a class="page-link" href="#">5</a></li>
                <li class="page-item"><a class="page-link" href="#">6</a></li>
                <li class="page-item"><a class="page-link" href="#">7</a></li>
                <li class="page-item"><a class="page-link" href="#">8</a></li>
            </ul>-->
        </nav>
    </div>
    <!-- /.card-footer -->
</div>
<!-- /.card -->
