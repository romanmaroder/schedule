<?php


namespace shop\widgets\Header\NavbarOther;


use yii\base\Widget;

class NavbarOther extends Widget
{
    public $url;

    public function __construct( $url, $config = [])
    {
        $this->url = $url;
        parent::__construct($config);
    }

    public function run(): string
    {
        return $this->render('navbar-other',[
            'url'=>$this->url
        ]);
    }
}