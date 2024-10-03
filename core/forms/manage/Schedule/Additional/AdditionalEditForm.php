<?php


namespace core\forms\manage\Schedule\Additional;


use core\entities\Schedule\Additional\Additional;
use core\forms\CompositeForm;
use core\forms\manage\MetaForm;
use core\helpers\tHelper;

/**
 * @property MetaForm $meta
 * @property CategoriesForm $categories
 */
class AdditionalEditForm extends CompositeForm
{
    public $name;
    public $description;

    private $_service;

    public function __construct(Additional $service, $config = [])
    {
        $this->name = $service->name;
        $this->description = $service->description;
        $this->meta = new MetaForm($service->meta);
        $this->categories = new CategoriesForm($service);

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
            'name'=>tHelper::t('schedule/additional','Name'),
            'description'=>tHelper::t('schedule/additional','Description'),
        ];
    }

    protected function internalForms(): array
    {
        return ['meta','categories'];
    }
}