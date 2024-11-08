<?php


/* @var $this \yii\web\View */

/* @var $expense \core\entities\Expenses\Expenses\Expenses */


use hail812\adminlte3\assets\PluginAsset;
use core\helpers\ExpenseHelper;
use core\helpers\PriceHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

$this->title = $expense->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('expenses/expenses','Expenses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

YiiAsset::register($this);
PluginAsset::register($this)->add(['sweetalert2']);
?>
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col">
            <div class="card card-secondary">
                <div class='card-header'>
                    <h3 class='card-title'>
                        <?php
                        if ($expense->isActive()) : ?>
                            <?= Html::a(
                                Yii::t('app','Draft'),
                                ['draft', 'id' => $expense->id],
                                ['class' => 'btn btn-primary btn-shadow btn-sm btn-gradient', 'data-method' => 'post']
                            ) ?>
                        <?php
                        else : ?>
                            <?= Html::a(
                                Yii::t('app','Activate'),
                                ['activate', 'id' => $expense->id],
                                ['class' => 'btn btn-success btn-shadow btn-sm btn-gradient', 'data-method' => 'post']
                            ) ?>
                        <?php
                        endif; ?>
                        <?= Html::a(
                            Yii::t('app','Update'),
                            ['update', 'id' => $expense->id],
                            ['class' => 'btn btn-primary btn-shadow btn-sm btn-gradient']
                        ) ?>
                        <?= Html::a(
                            Yii::t('app','Delete'),
                            ['delete', 'id' => $expense->id],
                            [
                                'class' => 'btn btn-danger btn-shadow btn-sm btn-gradient',
                                'data' => [
                                    'confirm' => Yii::t('app', 'Delete file?'),
                                    'method' => 'post',
                                ],
                            ]
                        ) ?>

                    </h3>
                    <div class='card-tools'>
                        <button type='button' class='btn btn-tool' data-card-widget='maximize'><i
                                    class='fas fa-expand'></i>
                        </button>
                        <button type='button' class='btn btn-tool' data-card-widget='collapse'><i
                                    class='fas fa-minus'></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <?= DetailView::widget(
                        [
                            'model' => $expense,
                            'attributes' => [
                                'id',
                                [
                                    'attribute' => 'status',
                                    'value' => ExpenseHelper::statusLabel($expense->status),
                                    'format' => 'raw',
                                ],
                                'name',
                                [
                                    'attribute' => 'value',
                                    'value' => PriceHelper::format($expense->value),
                                ],
                                [
                                    'attribute' => 'category_id',
                                    'value' => ArrayHelper::getValue($expense, 'category.name'),
                                ],
                                [
                                    'attribute' => 'category.others',
                                    //'label' => 'Other categories',
                                    'value' => implode(', ', ArrayHelper::getColumn($expense->categories, 'name')),
                                ],
                                [
                                    'attribute' => 'tags.name',
                                    //'label' => 'Tags',
                                    'value' => implode(', ', ArrayHelper::getColumn($expense->tags, 'name')),
                                ],
                            ],
                        ]
                    ) ?>
                </div>
            </div>
        </div>
    </div>
</div>