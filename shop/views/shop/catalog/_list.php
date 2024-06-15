<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\DataProviderInterface */

use yii\bootstrap4\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<!--<div class="row">
    <div class="col-md-2 col-sm-6 hidden-xs">
        <div class="btn-group btn-group-sm">
            <button type="button" id="list-view" class="btn btn-default" data-toggle="tooltip" title="List"><i class="fa fa-th-list"></i></button>
            <button type="button" id="grid-view" class="btn btn-default" data-toggle="tooltip" title="Grid"><i class="fa fa-th"></i></button>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="form-group">
            <a href="/index.php?route=product/compare" id="compare-total" class="btn btn-link">Product Compare (0)</a>
        </div>
    </div>
    <div class="col-md-4 col-xs-6">
        <div class="form-group input-group input-group-sm">
            <label class="input-group-addon" for="input-sort">Sort By:</label>
            <select id="input-sort" class="form-control" onchange="location = this.value;">
                <?php
/*                $values = [
                    '' => 'Default',
                    'name' => 'Name (A - Z)',
                    '-name' => 'Name (Z - A)',
                    'price' => 'Price (Low &gt; High)',
                    '-price' => 'Price (High &gt; Low)',
                    '-rating' => 'Rating (Highest)',
                    'rating' => 'Rating (Lowest)',
                ];
                $current = Yii::$app->request->get('sort');
                */ ?>
                <?php
/*foreach ($values as $value => $label): */ ?>
                    <option value="<?
/*= Html::encode(Url::current(['sort' => $value ?: null])) */ ?>" <?php
/*if ($current == $value): */ ?>selected="selected"<?php
/*endif; */ ?>><?
/*= $label */ ?></option>
                <?php
/*endforeach; */ ?>
            </select>
        </div>
    </div>
    <div class="col-md-3 col-xs-6">
        <div class="form-group input-group input-group-sm">
            <label class="input-group-addon" for="input-limit">Show:</label>
            <select id="input-limit" class="form-control" onchange="location = this.value;">
                <?php
/*                $values = [15, 25, 50, 75, 100];
                $current = $dataProvider->getPagination()->getPageSize();
                */ ?>
                <?php
/*foreach ($values as $value): */ ?>
                    <option value="<?
/*= Html::encode(Url::current(['per-page' => $value])) */ ?>" <?php
/*if ($current == $value): */ ?>selected="selected"<?php
/*endif; */ ?>><?
/*= $value */ ?></option>
                <?php
/*endforeach; */ ?>
            </select>
        </div>
    </div>
</div>-->


<!-- Shop Product Start -->
<div class="col-lg-9 col-md-12">
    <div class="row pb-3">
        <div class="col-12 pb-1">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <form action="">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search by name">
                        <div class="input-group-append">
                                        <span class="input-group-text bg-transparent text-primary">
                                            <i class="fa fa-search"></i>
                                        </span>
                        </div>
                    </div>
                </form>
                <div class="dropdown ml-4">
                    <select id="input-sort" class="form-control" onchange="location = this.value;">
                        <?php
                        $values = [
                            '' => 'Default',
                            'name' => 'Name (A - Z)',
                            '-name' => 'Name (Z - A)',
                            'price' => 'Price (Low &gt; High)',
                            '-price' => 'Price (High &gt; Low)',
                            '-rating' => 'Rating (Highest)',
                            'rating' => 'Rating (Lowest)',
                        ];
                        $current = Yii::$app->request->get('sort');
                        ?>
                        <?php
                        foreach ($values as $value => $label): ?>
                            <option value="<?= Html::encode(Url::current(['sort' => $value ?: null])) ?>"
                                <?php
                                if ($current == $value): ?>
                                    selected="selected"
                                <?php
                                endif; ?>>
                                <?= $label ?>
                            </option>
                        <?php
                        endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <?php
        foreach ($dataProvider->getModels() as $product): ?>
            <?= $this->render(
                '_product',
                [
                    'product' => $product
                ]
            ) ?>
        <?php
        endforeach; ?>
        <div class="col-12 pb-1">

            <nav aria-label="Page navigation">
                <?= LinkPager::widget(
                    [
                        'pagination' => $dataProvider->getPagination(),
                        'listOptions' => [
                            'class' => 'pagination justify-content-center mb-3',
                        ],
                        'linkOptions' => [
                            'class' => 'page-link',
                        ],
                        'linkContainerOptions' => [
                            'class' => 'page-item'
                        ],
                        'prevPageCssClass' => 'page-item',
                        'nextPageCssClass' => 'page-item',
                        'prevPageLabel' => '<span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>',
                        'nextPageLabel' => '<span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>',
                        'hideOnSinglePage' => false,

                    ]
                ) ?>
            </nav>
        </div>
    </div>

</div>
<!-- Shop Product End -->

<!-- Shop End -->

<!--<div class="row">
    <div class="col-sm-6 text-left">
        <?/*= LinkPager::widget(
            [
                'pagination' => $dataProvider->getPagination(),
            ]
        ) */?>
    </div>
    <div class="col-sm-6 text-right">Showing <?/*= $dataProvider->getCount() */?> of <?/*= $dataProvider->getTotalCount() */?></div>
</div>-->