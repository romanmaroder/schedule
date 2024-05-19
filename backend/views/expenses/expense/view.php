<?php


/* @var $this \yii\web\View */

/* @var $expense \schedule\entities\Expenses\Expenses\Expenses */


use hail812\adminlte3\assets\PluginAsset;
use schedule\helpers\ExpenseHelper;
use schedule\helpers\PriceHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

$this->title = $expense->name;
$this->params['breadcrumbs'][] = ['label' => 'Expenses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

YiiAsset::register($this);
PluginAsset::register($this)->add(['sweetalert2']);
?>
<div class="expense-view">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class='card-header'>
                    <h3 class='card-title'>
                        <?php
                        if ($expense->isActive()) : ?>
                            <?= Html::a(
                                'Draft',
                                ['draft', 'id' => $expense->id],
                                ['class' => 'btn btn-primary btn-shadow btn-sm btn-gradient', 'data-method' => 'post']
                            ) ?>
                        <?php
                        else : ?>
                            <?= Html::a(
                                'Activate',
                                ['activate', 'id' => $expense->id],
                                ['class' => 'btn btn-success btn-shadow btn-sm btn-gradient', 'data-method' => 'post']
                            ) ?>
                        <?php
                        endif; ?>
                        <?= Html::a(
                            'Update',
                            ['update', 'id' => $expense->id],
                            ['class' => 'btn btn-primary btn-shadow btn-sm btn-gradient']
                        ) ?>
                        <?= Html::a(
                            'Delete',
                            ['delete', 'id' => $expense->id],
                            [
                                'class' => 'btn btn-danger btn-shadow btn-sm btn-gradient',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
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
                                    'label' => 'Other categories',
                                    'value' => implode(', ', ArrayHelper::getColumn($expense->categories, 'name')),
                                ],
                                [
                                    'label' => 'Tags',
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