<?php


namespace shop\widgets\Header\NavbarMenu;


use yii\base\Widget;

class NavbarMenu extends Widget
{

    public function run(): string
    {
        return $this->render('navbar-menu');
    }
}