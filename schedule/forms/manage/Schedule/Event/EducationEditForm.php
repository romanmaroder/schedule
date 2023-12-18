<?php


namespace schedule\forms\manage\Schedule\Event;


use schedule\entities\Schedule\Event\Education;
use schedule\forms\CompositeForm;

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

    protected function internalForms(): array
    {
        return ['teacher','student','students'];
    }
}