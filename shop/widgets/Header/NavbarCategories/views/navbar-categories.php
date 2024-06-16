<?php



/* @var $this \yii\web\View */
use yii\helpers\Html;

?>
<div class="navbar-nav w-100 overflow-hidden" style="height: 410px">
    <div class="nav-item dropdown">
        <a href="#" class="nav-link" data-toggle="dropdown">Dresses <i
                class="fa fa-angle-down float-right mt-1"></i></a>
        <div class="dropdown-menu position-absolute bg-secondary border-0 rounded-0 w-100 m-0">
            <a href="" class="dropdown-item">Men's Dresses</a>
            <a href="" class="dropdown-item">Women's Dresses</a>
            <a href="" class="dropdown-item">Baby's Dresses</a>
        </div>
    </div>
    <a href="" class="nav-item nav-link">Shirts</a>
    <a href="" class="nav-item nav-link">Jeans</a>
    <a href="" class="nav-item nav-link">Swimwear</a>
    <a href="" class="nav-item nav-link">Sleepwear</a>
    <a href="" class="nav-item nav-link">Sportswear</a>
    <a href="" class="nav-item nav-link">Jumpsuits</a>
    <a href="" class="nav-item nav-link">Blazers</a>
    <a href="" class="nav-item nav-link">Jackets</a>
    <a href="" class="nav-item nav-link">Shoes</a>
</div>
<?php
/*
private function printNode($categories, $depth = 1)
    {
        if (is_array($categories)) {
            echo Html::beginTag('ul', ['class' => $depth == 1 ? 'cat_menu' : 'sub_menu']);

            foreach ($categories as $category) {
                $active = $this->active && ($this->active->id == $category->id || $this->active->isChildOf($category));

                if ($category->depth == $depth) {

                    echo Html::beginTag('li', ['class' => $category->children ? 'hassubs' : '']);

                    echo Html::a(Html::encode($category->name) . ($category->children ? "<i class='fas fa-chevron-right'></i>" : ''),
                        ['/core/catalog/category', 'id' => $category->id],['class' => $active ? 'active' : '']
                    );

                    if ($category->children) {
                        $this->printNode($category->children, ++$category->depth);
                    }

                    echo Html::endTag('li');
                }
            }
            echo Html::endTag('ul');
        }
    }

*/?>
<?= \shop\widgets\MainNavCategoriesWidget::widget()?>
