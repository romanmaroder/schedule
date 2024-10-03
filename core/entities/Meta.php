<?php


namespace core\entities;


use core\helpers\tHelper;

class Meta
{
    public $title;
    public $description;
    public $keywords;

    /**
     * Meta constructor.
     * @param $title
     * @param $description
     * @param $keywords
     */
    public function __construct($title, $description, $keywords)
    {
        $this->title = $title;
        $this->description = $description;
        $this->keywords = $keywords;
    }
    public function attributeLabels()
    {
        return [
            'title' => tHelper::translate('meta', 'Title'),
            'description' => tHelper::translate('meta', 'Description'),
            'keywords' => tHelper::translate('meta', 'Keywords'),
        ];
    }

}