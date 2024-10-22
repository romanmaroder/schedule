<?php


namespace core\forms\manage\User\Rate;


use core\entities\User\Rate;
use core\helpers\tHelper;
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
            [['name'], 'required'],
            [['rate'], 'double'],
            [
                ['name'],
                'unique',
                'targetClass' => Rate::class,
                'filter' => $this->_rate ? ['<>', 'id', $this->_rate->id] : null
            ],
        ];
    }
    public function attributeLabels()
    {
        return [
            'name'=>tHelper::translate('rate','name'),
            'rate'=>tHelper::translate('rate','rate'),
        ];
    }
}