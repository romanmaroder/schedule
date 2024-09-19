<?php


namespace core\forms\manage\User\Price;


use core\entities\User\Price;
use core\forms\CompositeForm;


/**
 * @property ServicesForm $services
 */
class SimpleAddForm extends CompositeForm
{
    public $price;
    public $rate;

    public function __construct(Price $price, $config = [])
    {
        $this->price = $price;
        $this->services = new ServicesForm();
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
           [ ['rate','price'], 'integer'],
            ['rate', 'safe'],
            ['price', 'safe'],
        ];
    }

    protected function internalForms(): array
    {
        return ['services'];
    }
}