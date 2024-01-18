<?php


namespace schedule\forms\manage\Schedule\Event;


use schedule\entities\Schedule\Event\Event;
use schedule\entities\User\User;
use schedule\helpers\UserHelper;
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
            User::find()->joinWith(['employee','employee.role'])->orderBy('schedule_employees.id')->asArray()->all(),
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
}