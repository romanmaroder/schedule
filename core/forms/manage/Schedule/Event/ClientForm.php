<?php


namespace core\forms\manage\Schedule\Event;


use core\entities\Enums\UserStatusEnum;
use core\entities\Schedule\Event\Event;
use core\entities\User\User;
use core\helpers\tHelper;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class ClientForm extends Model
{
    public $client;

    public function __construct(Event $event = null, $config = [])
    {
        if ($event) {
            $this->client = $event->client;
        }
        parent::__construct($config);
    }

    public function userList(): array
    {
        return ArrayHelper::map(
            User::find()->joinWith(['employee','employee.role'])->where(['users.status'=> UserStatusEnum::STATUS_ACTIVE])->orderBy('schedule_employees.id')->asArray()->all(),
            'id',
            'username',
            'employee.role.name'
        );
    }

    public function rules():array
    {
        return [
            ['client','integer'],
            ['client','required']
        ];
    }

    public function attributeLabels()
    {
        return [
            'client' => tHelper::translate('schedule/event', 'Client'),
        ];
    }
}