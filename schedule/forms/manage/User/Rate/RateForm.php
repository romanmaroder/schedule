<?php


namespace schedule\forms\manage\User\Rate;


use schedule\entities\User\Rate;
use yii\base\Model;

class RateForm extends Model
{
    public $name;
    public $rate;

    private $_rate;

    public function __construct(Rate $rate = null, $config = [])
    {
        if ($rate){
            $this->name = $rate->name;
            $this->rate = $rate->rate;
            $this->_rate = $rate;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name'], 'string'],
            [['rate'], 'double'],
            [['name'], 'unique', 'targetClass' => Rate::class],
        ];
    }
}