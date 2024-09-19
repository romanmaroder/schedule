<?php


namespace core\forms\manage\User\Price;


use core\entities\Schedule\Event\Event;
use core\entities\Schedule\Service\Service;
use core\entities\User\Price;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class ServicesForm extends Model
{
    public array $lists = [];

    public function __construct(Price $price = null, $config = [])
    {
        if ($price) {
            $this->lists = ArrayHelper::getColumn($price->serviceAssignments, 'service_id');
        }
        parent::__construct($config);
    }

    public function servicesList(): array
    {
        return ArrayHelper::map(Service::find()->joinWith('category')->active()->all(),
                                'id',
                                'name',
                                'category.parent.name'
        );

    }

    public function rules()
    {
        return [
            ['lists', 'each', 'rule' => ['integer']],
            ['lists', 'default', 'value' => []],
            ['lists','required']
        ];
    }

}