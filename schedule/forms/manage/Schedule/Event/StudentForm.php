<?php


namespace schedule\forms\manage\Schedule\Event;


use schedule\entities\Schedule\Event\Education;
use schedule\entities\User\User;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class StudentForm extends Model
{
    public $student;

    public function __construct(Education $education = null, $config = [])
    {
        if ($education) {
            $this->student = $education->student;
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
            ['student','integer'],
            ['student','required']
        ];
    }
}