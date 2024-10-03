<?php


namespace core\forms\manage\Schedule\Event;


use core\entities\Schedule\Event\Education;
use core\entities\User\Employee\Employee;
use core\helpers\tHelper;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class StudentForm extends Model
{
    public $students=[];

    public function __construct(Education $education = null, $config = [])
    {
        if ($education) {
            $this->students =  $education->students;
        }
        parent::__construct($config);
    }

    public function studentList(): array
    {
        return ArrayHelper::map(Employee::find()->where(['role_id'=>3])->all(),'user_id',function($item){ return $item->getFullName();});
    }

    public function rules(): array
    {
        return [
            [['students'], 'required'],
            ['students', 'each', 'rule' => ['integer']],
            ['students', 'default', 'value' => []],
        ];
    }

    public function attributeLabels()
    {
        return [
            'students' => tHelper::translate('schedule/education', 'Students'),
        ];
    }

}