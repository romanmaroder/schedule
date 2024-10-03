<?php


namespace core\forms\manage\Blog;


use core\helpers\tHelper;
use yii\base\Model;

class CommentForm extends Model
{
    public $parentId;
    public $text;

    public function rules(): array
    {
        return [
            [['text'], 'required'],
            ['text', 'string'],
            ['parentId', 'integer'],
        ];
    }
    public function attributeLabels()
    {
        return[
            'text' => tHelper::translate('blog/comments', 'Text'),
            'parentId' => tHelper::translate('blog/comments', 'Parent Id'),
        ];
    }
}