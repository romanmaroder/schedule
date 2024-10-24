<?php


namespace core\forms\manage\Blog\Post;

use core\entities\Blog\Category;
use core\entities\Blog\Post\Post;
use core\forms\CompositeForm;
use core\forms\manage\MetaForm;
use core\helpers\tHelper;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * @property MetaForm $meta
 * @property TagsForm $tags
 */
class PostForm extends CompositeForm
{

    public $categoryId;
    public $title;
    public $description;
    public $content;
    /**
     * @var UploadedFile
     */
    public $file;

    public function __construct(Post $post = null, $config = [])
    {
        if ($post) {
            $this->categoryId = $post->category_id;
            $this->title = $post->title;
            $this->description = $post->description;
            $this->content = $post->content;
            $this->meta = new MetaForm($post->meta);
            $this->tags = new TagsForm($post);
        } else {
            $this->meta = new MetaForm();
            $this->tags = new TagsForm();
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['categoryId', 'title'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['categoryId'], 'integer'],
            [['description', 'content'], 'string'],
            //['files', 'each', 'rule' => ['image']],
            [['file'], 'image'],
        ];
    }

    public function attributeLabels()
    {
        return[
            'title' => tHelper::translate('blog', 'Title'),
            'description' => tHelper::translate('blog', 'Description'),
            'content' => tHelper::translate('blog', 'Content'),
            'categoryId' => tHelper::translate('blog', 'Category'),
        ];
    }
    public function categoriesList(): array
    {
        return ArrayHelper::map(Category::find()->orderBy('sort')->asArray()->all(), 'id', 'name');
    }

    protected function internalForms(): array
    {
        return ['meta', 'tags'];
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->file = UploadedFile::getInstance($this, 'file');
            return true;
        }
        return false;
    }

}