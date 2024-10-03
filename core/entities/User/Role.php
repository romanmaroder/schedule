<?php


namespace core\entities\User;


use core\helpers\tHelper;
use yii\db\ActiveRecord;

/**
 * Roles model
 *
 * @property int $id
 * @property string $name
 */
class Role extends ActiveRecord
{
    public static function create($name): self
    {
        $role = new static();
        $role->name = $name;
        return $role;
    }

    public function edit($name)
    {
        $this->name = $name;
    }

    public function attributeLabels()
    {
        return [
            'name'=>tHelper::translate('role','name'),
        ];
    }

    public static function tableName(): string
    {
        return '{{%schedule_roles}}';
    }
}