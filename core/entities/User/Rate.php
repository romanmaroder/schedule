<?php


namespace core\entities\User;


use core\helpers\tHelper;
use yii\db\ActiveRecord;


/**
 * Rate model
 *
 * @property int $id
 * @property string $name
 * @property int $rate
 */
class Rate extends ActiveRecord
{

    public static function create($name, $rate): self
    {
        $stake = new static();
        $stake->name = $name;
        $stake->rate = $rate;
        return $stake;
    }

    public function edit($name, $rate): void
    {
        $this->name = $name;
        $this->rate = $rate;
    }

    public function attributeLabels()
    {
        return [
            'name'=>tHelper::translate('rate','name'),
            'rate'=>tHelper::translate('rate','rate'),
        ];
    }

    public static function tableName(): string
    {
        return '{{%schedule_rates}}';
    }
}