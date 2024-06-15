<?php


namespace shop\widgets\Header\NavbarMain;


use yii\base\Widget;

class NavbarMain extends Widget
{
    public $url;

    public function __construct( $url, $config = [])
    {
        $this->url = $url;
        parent::__construct($config);
    }

    public function run(): string
    {
        return $this->render('navbar-main',[
            'url'=>$this->url
        ]);
    }
}