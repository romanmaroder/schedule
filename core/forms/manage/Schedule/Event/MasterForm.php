<?php


namespace core\forms\manage\Schedule\Event;


use core\entities\Schedule\Event\Event;
use core\entities\User\Employee\Employee;
use core\helpers\tHelper;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class MasterForm extends Model
{
    public $master;

    public function __construct(Event $event = null, $config = [])
    {
        if ($event) {
            $this->master = $event->master;
        }
        parent::__construct($config);
    }

    public function masterList(): array
    {
        return ArrayHelper::map(Employee::find()->joinWith('role')->where(['not in', 'name', ['admin','Admin']])->active()->asArray()->all(),
                                'user_id',function ($employee) {

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
            'master' => tHelper::translate('schedule/event', 'Master'),
        ];
    }
}