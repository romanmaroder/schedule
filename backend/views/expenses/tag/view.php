<?php



/* @var $this \yii\web\View */
/* @var $tag \core\entities\Expenses\Expenses\Tag*/


use hail812\adminlte3\assets\PluginAsset;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

$this->title = $tag->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('expenses/tag','Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

YiiAsset::register($this);
PluginAsset::register($this)->add(['sweetalert2']);
?>
<div class="tag-view">
    <div class="card card-secondary">
        <div class="card-header">
            <?= Html::a(Yii::t('app','Update'), ['update', 'id' => $tag->id], ['class' => 'btn btn-primary btn-sm btn-shadow bg-gradient text-shadow']) ?>
            <?= Html::a(
                Yii::t('app','Delete'),
                ['delete', 'id' => $tag->id],
                [
                    'class' => 'btn btn-danger btn-sm btn-shadow bg-gradient text-shadow',
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
                    'model' => $tag,
                    'attributes' => [
                        'id',
                        'name',
                        'slug',
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