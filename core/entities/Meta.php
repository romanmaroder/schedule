<?php


namespace core\entities;


use core\helpers\tHelper;

readonly class Meta
{
    public null|string $title;
    public null|string $description;
    public null|string $keywords;

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
    public function attributeLabels(): array
    {
        return [
            'title' => tHelper::translate('meta', 'Title'),
            'description' => tHelper::translate('meta', 'Description'),
            'keywords' => tHelper::translate('meta', 'Keywords'),
        ];
    }

}