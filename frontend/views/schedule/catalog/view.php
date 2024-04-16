<?php

/* @var $this yii\web\View */

/* @var $service \schedule\entities\Schedule\Service\Service */
/* @var $user \schedule\entities\User\User */

/* @var $category \schedule\entities\Schedule\Category */
/* @var $menu \schedule\entities\Schedule\Category */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $service->name;
$this->params['breadcrumbs'][] = ['label' => $category->parent->name ?: $category->name, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;



?>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Description</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <?= $this->render(
                    '_one',
                    [
                        'service' => $service,
                        'category'=>$category
                    ]
                );
                ?>
                <div class="col-12 col-md-12 col-lg-4 order-2 order-md-2">
                    <h3 class="text-primary"><i class="fas fa-paint-brush"></i> Services</h3>

                        <ul class="nav flex-column">
                        <?php foreach ($menu as $child): ?>
                            <?
                            echo Html::tag(
                                'li',
                                Html::a(
                                    Html::encode($child->name),
                                    Html::encode(Url::to(['view', 'id' => $child->id])),
                                    ['class' => ['nav-link aside-menu',  Yii::$app->request->get('id') == $child->id ? 'active' : '']]
                                ),
                                ['class' => ['nav-item text-sm']]
                            ); ?>
                        <?php
                        endforeach; ?>
                        </ul>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->


<!--<div class="panel panel-default">
    <div class="panel-body">
        <?php
/*        foreach ($category->children as $child): */?>
            <a href="<?/*= Html::encode(Url::to(['category', 'id' => $child->id])) */?>"><?/*= Html::encode(
                    $child->name
                ) */?></a> &nbsp;
        <?php
/*        endforeach; */?>
    </div>
</div>-->