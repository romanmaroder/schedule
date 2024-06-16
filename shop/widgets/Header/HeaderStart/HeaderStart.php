<?php


namespace shop\widgets\Header\HeaderStart;


use yii\base\Widget;

class HeaderStart extends Widget
{
    public $title;
    public $url;

    public function __construct($title, $url, $config = [])
    {
        $this->title = $title;
        $this->url = $url;
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