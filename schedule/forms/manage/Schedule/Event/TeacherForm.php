<?php


namespace schedule\forms\manage\Schedule\Event;


use schedule\entities\Schedule\Event\Education;
use schedule\entities\User\Employee\Employee;
use schedule\entities\User\User;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class TeacherForm extends Model
{
    public $teacher;

    public function __construct(Education $education = null, $config = [])
    {
        if ($education) {
            $this->teacher = $education->teacher;
        }
        parent::__construct($config);
    }

    public function teacherList(): array
    {
        return ArrayHelper::map(Employee::find()->where(['role_id'=>2])->all(),'user_id',function($item){ return $item->getFullName();});
    }

    public function rules():array
    {
        return [
            ['teacher','integer'],
            ['teacher','required']
        ];
    }
}