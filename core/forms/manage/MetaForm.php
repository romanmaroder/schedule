<?php


namespace core\forms\manage;


use core\entities\Meta;
use core\helpers\tHelper;
use yii\base\Model;

class MetaForm extends Model
{
    public $title;
    public $description;
    public $keywords;

    public function __construct(Meta $meta = null, $config = [])
    {
        if ($meta) {
            $this->title = $meta->title;
            $this->description = $meta->description;
            $this->keywords = $meta->keywords;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['title'], 'string', 'max' => 255],
            [['description', 'keywords'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return[
            'title' => tHelper::translate('meta', 'Title'),
            'description' => tHelper::translate('meta', 'Description'),
            'keywords' => tHelper::translate('meta', 'Keywords'),
        ];
    }

}