<?php

use hail812\adminlte3\assets\PluginAsset;
use schedule\helpers\CharacteristicHelper;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $characteristic schedule\entities\Schedule\Characteristic */

$this->title = $characteristic->name;
$this->params['breadcrumbs'][] = ['label' => 'Characteristic', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

YiiAsset::register($this);
PluginAsset::register($this)->add(['sweetalert2']);
?>
<div class="characteristic-view">

    <div class="card card-secondary">
        <div class="card-header">
            <?= Html::a('Update', ['update', 'id' => $characteristic->id], ['class' => 'btn btn-primary btn-shadow']) ?>
            <?= Html::a(
                'Delete',
                ['delete', 'id' => $characteristic->id],
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
                    'model' => $characteristic,
                    'attributes' => [
                        'id',
                        'name',
                        [
                            'attribute' => 'type',
                            'value' => CharacteristicHelper::typeName($characteristic->type),
                        ],
                        'sort',
                        'required:boolean',
                        'default',
                        [
                            'attribute' => 'variants',
                            'value' => implode(PHP_EOL, $characteristic->variants),
                            'format' => 'ntext',
                        ],
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