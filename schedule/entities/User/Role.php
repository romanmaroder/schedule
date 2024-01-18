<?php


namespace schedule\entities\User;


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

    public static function tableName(): string
    {
        return '{{%schedule_roles}}';
    }
}