<?php


namespace core\forms\manage\User\Price;


use core\entities\User\Price;
use yii\base\Model;

class PriceForm extends Model
{
    public $name;
    public $rate;

    private $_rate;

    public function __construct(Price $price = null, $config = [])
    {
        if ($price){
            $this->name = $price->name;
            $this->rate = $price->rate;
            $this->_rate = $price;
        }
        parent::__construct($config);
    }

    public function rules():array
    {
        return [
            [['name'], 'string'],
            [['rate'], 'integer'],
           // [['rate'], 'double'],
            [
                ['name'],
                'unique',
                'targetClass' => Price::class,
                'filter' => $this->_rate ? ['<>', 'id', $this->_rate->id] : null
            ],
        ];
    }
}