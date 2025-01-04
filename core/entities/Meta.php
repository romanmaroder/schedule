<?php


namespace core\entities;


use core\helpers\tHelper;

readonly class Meta
{
    /**
     * Meta constructor.
     * @param string|null $title
     * @param string|null $description
     * @param string|null $keywords
     */
    public function __construct(
        public null|string $title,
        public null|string $description,
        public null|string $keywords,
    ) {}

    public function attributeLabels(): array
    {
        return [
            'title' => tHelper::translate('meta', 'Title'),
            'description' => tHelper::translate('meta', 'Description'),
            'keywords' => tHelper::translate('meta', 'Keywords'),
        ];
    }

}