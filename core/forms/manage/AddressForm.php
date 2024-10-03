<?php


namespace core\forms\manage;


use core\entities\Address;
use core\helpers\tHelper;
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
    public function attributeLabels()
    {
        return [
            'town'=>tHelper::translate('user/address','town'),
            'borough'=>tHelper::translate('user/address','borough'),
            'street'=>tHelper::translate('user/address','street'),
            'home'=>tHelper::translate('user/address','home'),
            'apartment'=>tHelper::translate('user/address','apartment'),
        ];
    }
}