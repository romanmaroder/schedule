<?php


namespace schedule\forms\manage\Schedule\Event;


use schedule\entities\Schedule\Event\Education;
use schedule\entities\User\User;
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
        return ArrayHelper::map(User::find()->all(),'id','username');
    }

    public function rules():array
    {
        return [
            [['students'],'required'],
            ['students', 'each', 'rule' => ['integer']],
            ['students', 'default', 'value' => []],
        ];
    }

}