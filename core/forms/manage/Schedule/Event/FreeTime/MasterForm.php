<?php


namespace core\forms\manage\Schedule\Event\FreeTime;


use core\entities\Schedule\Event\FreeTime;
use core\entities\User\Employee\Employee;
use core\helpers\tHelper;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class MasterForm extends Model
{
    public $master;

    public function __construct(FreeTime $freeTime = null, $config = [])
    {
        if ($freeTime) {
            $this->master = $freeTime->master_id;
        }
        parent::__construct($config);
    }

    public function masterList(): array
    {
        return ArrayHelper::map(Employee::find()->joinWith('role')->where(['not in', 'name', ['admin']])->active()->asArray()->all(),'user_id',function ($employee) {

            return $employee['first_name'].' '.$employee['last_name'];

        },'role.name');
    }

    public function rules():array
    {
        return [
            ['master','integer'],
            ['master','required']
        ];
    }

    public function attributeLabels()
    {
        return [
            'master' => tHelper::translate('schedule/free','Master'),
        ];
    }
}