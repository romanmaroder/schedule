<?php


namespace core\forms\manage\Blog;


use core\entities\Blog\Tag;
use core\helpers\tHelper;
use core\validators\SlugValidator;
use yii\base\Model;

class TagForm extends Model
{
    public $name;
    public $slug;

    private $_tag;

    public function __construct(Tag $tag = null, $config = [])
    {
        if ($tag) {
            $this->name = $tag->name;
            $this->slug = $tag->slug;
            $this->_tag = $tag;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name', 'slug'], 'required'],
            [['name', 'slug'], 'string', 'max' => 255],
            ['slug', SlugValidator::class],
            [
                ['name', 'slug'],
                'unique',
                'targetClass' => Tag::class,
                'filter' => $this->_tag ? ['<>', 'id', $this->_tag->id] : null
            ]
        ];
    }
    public function attributeLabels()
    {
        return[
            'name' => tHelper::translate('blog/tag', 'Name'),
            'slug' => tHelper::translate('blog/tag', 'Slug'),
        ];
    }
}