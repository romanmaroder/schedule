<?php


namespace schedule\forms\manage\Schedule\Service;


use schedule\entities\Schedule\Service\Service;
use schedule\forms\CompositeForm;
use schedule\forms\manage\MetaForm;

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

    protected function internalForms(): array
    {
        return ['meta', 'tags'];
    }
}