<?php


namespace core\forms\manage\Schedule\Service;


use core\entities\Schedule\Service\Service;
use core\forms\CompositeForm;
use core\forms\manage\MetaForm;
use core\helpers\tHelper;

/**
 * @property MetaForm $meta
 * @property CategoriesForm $categories
 * @property TagsForm $tags
 */
class ServiceEditForm extends CompositeForm
{
    public $name;
    public $description;

    private $_service;

    public function __construct(Service $service, $config = [])
    {
        $this->name = $service->name;
        $this->description = $service->description;
        $this->meta = new MetaForm($service->meta);
        $this->categories = new CategoriesForm($service);
        $this->tags = new TagsForm($service);

        $this->_service = $service;

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [[ 'name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['description'],'string'],
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
        return ['meta', 'tags','categories'];
    }
}