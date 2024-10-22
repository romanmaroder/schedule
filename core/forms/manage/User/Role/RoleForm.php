<?php


namespace core\forms\manage\User\Role;


use core\entities\User\Role;
use core\helpers\tHelper;
use yii\base\Model;

class RoleForm extends Model
{
    public $name;

    private $_role;

    public function __construct(Role $role = null, $config = [])
    {
        if ($role){
            $this->name = $role->name;
            $this->_role = $role;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name'], 'string'],
            [['name'], 'required'],
            [
                ['name'],
                'unique',
                'targetClass' => Role::class,
                'filter' => $this->_role ? ['<>', 'id', $this->_role->id] : null
            ],
        ];
    }
    public function attributeLabels()
    {
        return [
            'name' => tHelper::translate('role','name'),
        ];
    }
}