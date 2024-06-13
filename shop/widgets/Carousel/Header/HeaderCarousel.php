<?php


namespace shop\widgets\Carousel\Header;


use yii\base\Widget;
use yii\helpers\Url;

class HeaderCarousel extends Widget
{
    public $url;

    public function __construct($url, $config = [])
    {
        $this->url = $url;
        parent::__construct($config);
    }

    public function run(): string
    {
        return $this->render('header-carousel',[
            'url'=>$this->url
        ]);
    }
}