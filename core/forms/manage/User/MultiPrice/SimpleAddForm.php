<?php


namespace core\forms\manage\User\MultiPrice;


use core\entities\User\MultiPrice;
use core\forms\CompositeForm;


/**
 * @property ServicesForm $services
 */
class SimpleAddForm extends CompositeForm
{
    public $price;
    public $rate;

    public function __construct(MultiPrice $price, $config = [])
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