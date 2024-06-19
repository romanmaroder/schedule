<?php



/* @var $this \yii\web\View */

use shop\widgets\Header\NavbarCategories\MainNavCategoriesWidget;

?>
<div class="navbar-nav w-100 overflow-hidden" style="height: 410px">
<?= MainNavCategoriesWidget::widget(['active' => $this->params['active_category'] ?? null])?>
</div>

