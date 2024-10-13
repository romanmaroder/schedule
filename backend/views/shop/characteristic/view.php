<?php

use hail812\adminlte3\assets\PluginAsset;
use core\helpers\CharacteristicHelper;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $characteristic \core\entities\CommonUses\Characteristic */

$this->title = $characteristic->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('shop/characteristic','Characteristic'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

YiiAsset::register($this);
PluginAsset::register($this)->add(['sweetalert2']);
?>
<div class="characteristic-view">

    <div class="card card-secondary">
        <div class="card-header">
            <?= Html::a(Yii::t('app','Update'), ['update', 'id' => $characteristic->id], ['class' => 'btn btn-primary btn-sm btn-shadow btn-gradient']) ?>
            <?= Html::a(
                Yii::t('app','Delete'),
                ['delete', 'id' => $characteristic->id],
                [
                    'class' => 'btn btn-danger btn-sm btn-shadow btn-gradient',
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