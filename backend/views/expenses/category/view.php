<?php



/* @var $this \yii\web\View */
/* @var $category \core\entities\Expenses\Category */

use hail812\adminlte3\assets\PluginAsset;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

$this->title = $category->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('expenses/category','Categories expenses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

YiiAsset::register($this);
PluginAsset::register($this)->add(['sweetalert2']);
?>
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col">
            <div class="card card-secondary">
                <div class="card-header">
                    <?= Html::a(Yii::t('app','Update'), ['update', 'id' => $category->id], ['class' => 'btn btn-primary btn-shadow btn-sm btn-gradient']) ?>
            <?= Html::a(
                Yii::t('app','Delete'),
                ['delete', 'id' => $category->id],
                [
                    'class' => 'btn btn-danger btn-shadow btn-sm btn-gradient',
                    'data' => [
                        'confirm' => Yii::t('app', 'Delete file?'),
                        'method' => 'post',
                    ],
                ]
            ) ?>

            <div class='card-tools'>
                <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
                </button>
                <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <?= DetailView::widget(
                [
                    'model' => $category,
                    'attributes' => [
                        'id',
                        'name',
                        'slug',
                        'title',
                    ],
                ]
            ) ?>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <!-- Footer-->
        </div>
        <!-- /.card-footer-->
    </div>
            <div class="card card-secondary">
        <div class="card-header">
            SEO
            <div class='card-tools'>
                <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
                </button>
                <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <?= DetailView::widget(
                [
                    'model' => $category,
                    'attributes' => [
                        'meta.title',
                        'meta.description',
                        'meta.keywords',
                    ],
                ]
            ) ?>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <!-- Footer-->
        </div>
        <!-- /.card-footer-->
    </div>
        </div>
    </div>
</div>