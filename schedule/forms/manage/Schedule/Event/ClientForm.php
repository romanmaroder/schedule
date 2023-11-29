<?php


namespace schedule\forms\manage\Schedule\Event;


use schedule\entities\Schedule\Event\Event;
use schedule\entities\User\User;
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
        return ArrayHelper::map(User::find()->all(),'id','username');
    }

    public function rules():array
    {
        return [
            ['client','integer'],
            ['client','required']
        ];
    }
}