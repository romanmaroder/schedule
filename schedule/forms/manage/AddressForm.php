<?php


namespace schedule\forms\manage;


use schedule\entities\Address;
use yii\base\Model;

class AddressForm extends Model
{
    public $town;
    public $borough;
    public $street;
    public $home;
    public $apartment;

    public function __construct(Address $address = null, $config = [])
    {
        if ($address) {
            $this->town = $address->town;
            $this->borough = $address->borough;
            $this->street = $address->street;
            $this->home = $address->home;
            $this->apartment = $address->apartment;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['town', 'borough', 'street'], 'string'],
            [['home', 'apartment'],'integer']
        ];
    }
}