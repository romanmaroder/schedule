<?php


namespace core\forms\manage\User\MultiPrice;


use core\forms\CompositeForm;


/**
 * @property ServicesForm $services
 */
class MultiPriceCreateForm extends CompositeForm
{

    public $name;
    public $rate;

    public function __construct($config = [])
    {
        $this->services= new ServicesForm();
        parent::__construct($config);
    }

    public function rules():array
    {
        return [
            [['name','rate'],'required'],
            ['name', 'string'],
            ['rate', 'integer'],
        ];
    }

    protected function internalForms(): array
    {
        return ['services'];
    }
}