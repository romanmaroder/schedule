<?php


namespace core\forms\manage\User\Price;


use core\entities\User\Price;
use core\forms\CompositeForm;


/**
 * @property ServicesForm $services
 */
class EditForm extends CompositeForm
{

    public $name;
    public $rate;
    private $_price;

    public function __construct(Price $price, $config = [])
    {
        $this->name = $price->name;
        $this->rate = $price->rate;
        $this->services = new ServicesForm($price);
        $this->_price = $price;
        parent::__construct($config);
    }

    public function rules():array
    {
        return [
            ['name', 'string'],
            ['rate', 'integer']
        ];
    }

    protected function internalForms(): array
    {
        return ['services'];
    }
}