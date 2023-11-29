<?php


namespace schedule\forms\manage\Schedule\Event;


use schedule\entities\Schedule\Event\Event;
use schedule\entities\User\User;
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
        return ArrayHelper::map(User::find()->asArray()->all(),'id','username');
    }

    public function rules():array
    {
        return [
            ['master','integer'],
            ['master','required']
        ];
    }
}