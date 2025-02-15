<?php



/* @var $this \yii\web\View */
/* @var $price \core\entities\User\Price */

use hail812\adminlte3\assets\PluginAsset;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

$this->title = $price->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('price','Prices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

YiiAsset::register($this);
PluginAsset::register($this)->add(['sweetalert2']);
?>
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col">
            <div class="card card-secondary">
                <div class="card-header">
                    <?= Html::a(Yii::t('app','Update'), ['update', 'id' => $price->id], ['class' => 'btn btn-primary btn-shadow btn-sm btn-gradient']) ?>
            <?= Html::a(
                Yii::t('app', 'Delete'),
                ['delete', 'id' => $price->id],
                [
                    'id' => 'delete',
                    'class' => 'btn btn-danger btn-sm btn-shadow bg-gradient',
                    'data' => [
                        'confirm' => Yii::t('app', 'Delete file?'),
                        'method' => 'POST',
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
    </div>
</div>