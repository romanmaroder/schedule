<?php

use schedule\entities\Schedule\Characteristic;
use schedule\helpers\CharacteristicHelper;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\Schedule\CharacteristicSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Characteristic';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="characteristic-index">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <?= Html::a('Create characteristic', ['create'], ['class' => 'btn btn-success']) ?>
            </h3>

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

            <?= GridView::widget(
                [
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        [
                            'attribute' => 'name',
                            'value' => function (Characteristic $model) {
                                return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'type',
                            'filter' => $searchModel->typesList(),
                            'value' => function (Characteristic $model) {
                                return CharacteristicHelper::typeName($model->type);
                            },
                        ],
                        [
                            'attribute' => 'required',
                            'filter' => $searchModel->requiredList(),
                            'format' => 'boolean',
                        ],
                        ['class' => ActionColumn::class],
                    ],
                ]
            ); ?>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <!--Footer-->
        </div>
        <!-- /.card-footer-->
    </div>
</div>