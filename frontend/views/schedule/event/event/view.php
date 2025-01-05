<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \core\entities\Schedule\Event\Event */
/* @var $cart \core\cart\schedule\Cart */

$this->title = $model->client->username;
$this->params['breadcrumbs'][] = ['label' => 'Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-view container-fluid">

    <?= DetailView::widget(
        [
            'model' => $model,
            'attributes' => [
                /*[
                    'attribute' => 'client_id',
                    'value' => function ($model) {
                        return Html::a(
                            Html::encode($model->client->username),
                            ['/users/user/view','id'=>$model->client->id]

                        );
                    },
                    'format' => 'raw',
                ],*/
                [
                    'attribute' => 'client.phone',
                    'value' => fn ($model) => Html::a(
                            Html::encode($model->client->phone),
                            'tel:' . $model->client->phone,
                            ['view', 'id' => $model->id]
                        ),
                    'format' => 'raw',
                ],

                [
                    'attribute' => 'service',
                    //'label' => 'service',
                    'value' => implode(', ', ArrayHelper::getColumn($model->services, 'name')),
                    'contentOptions' => ['class'=>'text-break'],
                ],
                [
                    'attribute' => 'start',
                    'format' => ['date', 'php:d-m-Y / H:i '],
                ],
                [
                    'attribute' => 'end',
                    'format' => ['date', 'php:d-m-Y / H:i'],
                ],
                [
                    'attribute' => 'notice',
                    'visible' => $model->issetNotice($model->notice),
                    'format' => 'ntext',
                ],
                [
                    'attribute' => 'master_id',
                    'value' => fn($model) => Html::a(
                        Html::encode($model->master->username),
                        ['/employee/view', 'id' => $model->employee->id]
                    ) ?? $model->getFullName(),
                    'format' => 'raw',
                    'visible' => Yii::$app->user->identity->getId() != $model->master_id,
                ],
                [
                    'attribute' => 'cost',
                    'value' => $model->getDiscountedPrice($model, $cart),
                    'visible' => Yii::$app->user->identity->getId() == $model->master_id,
                ],
            ],
        ]
    ) ?>
</div>