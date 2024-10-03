<?php


namespace core\forms\manage\Blog\Post;


use core\entities\Blog\Post\Comment;
use core\helpers\tHelper;
use yii\base\Model;

class CommentEditForm extends Model
{
    public $parentId;
    public $text;

    public function __construct(Comment $comment, $config = [])
    {
        $this->parentId = $comment->parent_id;
        $this->text = $comment->text;
        parent::__construct($config);
    }

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