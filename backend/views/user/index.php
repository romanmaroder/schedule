<?php

use kartik\date\DatePicker;
use schedule\entities\user\User;
use schedule\helpers\UserHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\forms\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
                <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
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

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                [
                    'attribute' => 'created_at',
                    'filter' => DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'date_from',
                        'attribute2' => 'date_to',
                        'type' => DatePicker::TYPE_RANGE,
                        'separator' => '-',
                        'pluginOptions' => [
                            'todayHighlight' => true,
                            'autoclose'=>true,
                            'format' => 'yyyy-mm-dd',
                        ],
                    ]),
                    'format' => 'datetime',
                ],
                [
                    'attribute' => 'username',
                    'value' => function (User $model) {
                        return Html::a(Html::encode($model->username), ['view', 'id' => $model->id]);
                    },
                    'format' => 'raw',
                ],
                'email:email',
                [
                    'attribute' => 'status',
                   // 'filter' => UserHelper::statusList(),
                    'filter' => Html::activeDropDownList($searchModel, 'status', UserHelper::statusList(),
                     ['prompt' => 'Select...', 'class' => 'form-control form-control-sm']),
                    'value' => function (User $model) {
                        return UserHelper::statusLabel($model->status);
                    },
                    'format' => 'raw',
                ],
                [
                    'class' => ActionColumn::class,
                    'urlCreator' => function ($action, User $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    }
                ],
            ],
        ]); ?>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
<!--Footer-->
    </div>
    <!-- /.card-footer-->
</div>

