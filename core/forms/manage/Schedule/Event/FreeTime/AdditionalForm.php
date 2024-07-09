<?php


namespace core\forms\manage\Schedule\Event\FreeTime;


use core\entities\Schedule\Additional\Additional;
use core\entities\Schedule\Event\FreeTime;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class AdditionalForm extends Model
{
    public $additional;

    public function __construct(FreeTime $freeTime = null, $config = [])
    {
        if ($freeTime) {
            $this->additional = $freeTime->additional_id;
        }
        parent::__construct($config);
    }

    public function additionalList(): array
    {
        return ArrayHelper::map(Additional::find()->active()->all(), 'id', 'name');
    }

    public function rules()
    {
        return [
            //['additional','integer'],
            ['additional','required']
        ];
    }

}