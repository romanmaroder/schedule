<?php


namespace schedule\forms\manage\Schedule\Event;


use schedule\entities\Schedule\Event\Education;
use schedule\entities\User\User;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class StudentForm extends Model
{
    public $student;
    public $students=[];

    public function __construct(Education $education = null, $config = [])
    {
        if ($education) {
            $this->student = $education->student_id;
            $this->students =  $education->students;
        }
        parent::__construct($config);
    }

    public function studentList(): array
    {
        return ArrayHelper::map(User::find()->all(),'id','username');
    }

    public function rules():array
    {
        return [
            ['student','integer'],
            [['student','students'],'required'],
            ['students', 'each', 'rule' => ['integer']],
            ['students', 'default', 'value' => []],
        ];
    }

}