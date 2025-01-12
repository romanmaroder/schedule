<?php


namespace shop\widgets\Header\HeaderStart;


use yii\base\Widget;

class HeaderStart extends Widget
{
    public function __construct(public $title, public $url, $config = [])
    {
        parent::__construct($config);
    }

    public function run(): string
    {
        return $this->render('header-start',[
            'title'=>$this->title,
            'url'=>$this->url,
        ]);
    }
}