<?php

use schedule\helpers\UserHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var schedule\entities\user\User $model */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>


<div class="card card-secondary">
    <div class="card-header">

        <div class='card-tools'>
            <button type='button' class='btn btn-tool' data-card-widget='maximize'><i class='fas fa-expand'></i>
            </button>
            <button type='button' class='btn btn-tool' data-card-widget='collapse'><i class='fas fa-minus'></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'username',
                'email:email',
                [
                    'attribute' => 'status',
                    'value' => UserHelper::statusLabel($model->status),
                    'format' => 'raw',
                ],
                'created_at:datetime',
                'updated_at:datetime',
            ],
        ]) ?>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
       <!-- Footer-->
    </div>
    <!-- /.card-footer-->
</div>

