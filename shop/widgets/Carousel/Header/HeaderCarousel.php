<?php


namespace shop\widgets\Carousel\Header;


use yii\base\Widget;

class HeaderCarousel extends Widget
{
    public function __construct(public $url, $config = [])
    {
        parent::__construct($config);
    }

    public function run(): string
    {
        return $this->render('header-carousel',[
            'url'=>$this->url
        ]);
    }
}