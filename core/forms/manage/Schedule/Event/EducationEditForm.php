<?php


namespace core\forms\manage\Schedule\Event;


use core\entities\Schedule\Event\Education;
use core\forms\CompositeForm;
use core\helpers\tHelper;

/**
 * @property TeacherForm $teacher
 * @property StudentForm $student
 * @property StudentForm $students
 */
class EducationEditForm extends CompositeForm
{

    public $title;
    public $description;
    public $color;
    public $start;
    public $end;

    private $_education;

    public function __construct(Education $education, $config = [])
    {
        $this->teacher = new TeacherForm($education);
        $this->student = new StudentForm($education);
        $this->students = new StudentForm($education);
        $this->title = $education->title;
        $this->description = $education->description;
        $this->color = $education->color;
        $this->start = $education->start;
        $this->end = $education->end;
        $this->_education = $education;
        parent::__construct($config);
    }

    public function rules():array
    {
        return [
            [['start', 'end'], 'required'],
            [['title','description','color'], 'string'],
            [['color'], 'default','value' => '#474D2A'],
            ];
    }

    public function attributeLabels()
    {
        return [
            'start' => tHelper::translate('schedule/education','Start'),
            'end' => tHelper::translate('schedule/education','End'),
            'title' => tHelper::translate('schedule/education','Title'),
            'color' => tHelper::translate('schedule/education','Color'),
            'description' => tHelper::translate('schedule/education','Description'),
        ];
    }

    protected function internalForms(): array
    {
        return ['teacher','student','students'];
    }
}