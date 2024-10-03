<?php


namespace core\forms\manage\Schedule\Service;


use core\forms\CompositeForm;
use core\forms\manage\MetaForm;
use core\helpers\tHelper;

/**
 * @property PriceForm $price
 * @property MetaForm $meta
 * @property CategoriesForm $categories
 * @property TagsForm $tags
 */
class ServiceCreateForm extends CompositeForm
{
    public $name;
    public $description;

    public function __construct($config = [])
    {
        $this->price = new PriceForm();
        $this->meta = new MetaForm();
        $this->categories = new CategoriesForm();
        $this->tags = new TagsForm();
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['description'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => tHelper::translate('schedule/service', 'Name'),
            'description' => tHelper::translate('schedule/service', 'Description'),
        ];
    }

    protected function internalForms(): array
    {
        return ['price', 'meta', 'categories', 'tags'];
    }

}
