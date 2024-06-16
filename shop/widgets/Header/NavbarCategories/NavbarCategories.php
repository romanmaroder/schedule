<?php


namespace shop\widgets\Header\NavbarCategories;


use yii\base\Widget;

class NavbarCategories extends Widget
{
    public function run(): string
    {
        return $this->render('navbar-categories');
    }
}