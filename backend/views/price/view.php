<?php



/* @var $this \yii\web\View */
/* @var $price null|\schedule\entities\User\Price */

use hail812\adminlte3\assets\PluginAsset;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

$this->title = $price->name;
$this->params['breadcrumbs'][] = ['label' => 'Price', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

YiiAsset::register($this);
PluginAsset::register($this)->add(['sweetalert2']);
?>
<div class="price-view">
    <div class="card card-secondary">
        <div class="card-header">
            <?= Html::a('Update', ['update', 'id' => $price->id], ['class' => 'btn btn-primary btn-shadow']) ?>
            <?= Html::a(
                'Delete',
                ['delete', 'id' => $price->id],
                [
                    'class' => 'btn btn-danger btn-shadow',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
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
                    'model' => $price,
                    'attributes' => [
                        'id',
                        'name',
                        'rate',
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