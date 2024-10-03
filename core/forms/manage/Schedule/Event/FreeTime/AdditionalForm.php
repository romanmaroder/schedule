<?php


namespace core\forms\manage\Schedule\Event\FreeTime;


use core\entities\Schedule\Additional\Additional;
use core\entities\Schedule\Event\FreeTime;
use core\helpers\tHelper;
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
        return ArrayHelper::map(Additional::find()->with('category')->active()->all(),
                                'id',
                                'name',
        'category.parent.name');
    }

    public function rules()
    {
        return [
            //['additional','integer'],
            ['additional','required']
        ];
    }

    public function attributeLabels()
    {
        return [
            'additional' => tHelper::translate('schedule/free','Additional'),
        ];
    }

}