<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\DataProviderInterface */

use yii\bootstrap4\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<!-- Shop Product Start -->

        <div class="col-lg-10 col-md-10">
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
                <?php if (!$dataProvider->getModels()):?>
                <div class="col-12 text-center">
                    <h2 class="text-primary">There are no products in the category</h2>
                </div>
                <?php else :?>
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
                <?php endif;?>
            </div>

        </div>

<!-- Shop Product End -->
