<?php


namespace core\forms\manage\User\MultiPrice;


use core\entities\User\MultiPrice;
use core\forms\CompositeForm;


/**
 * @property ServicesForm $services
 */
class MultiPriceSimpleEditForm extends CompositeForm
{


    public $rate;
    private $_price;

    public function __construct(MultiPrice $price, $config = [])
    {

        $this->rate = $price->rate;
        $this->services = new ServicesForm($price);
        $this->_price = $price;
        parent::__construct($config);
    }

    public function rules():array
    {
        return [
            ['rate', 'integer']
        ];
    }

    protected function internalForms(): array
    {
        return ['services'];
    }
}