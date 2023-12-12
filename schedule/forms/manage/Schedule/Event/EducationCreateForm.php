<?php


namespace schedule\forms\manage\Schedule\Event;


use schedule\forms\CompositeForm;

/**
 * @property TeacherForm $teacher
 * @property StudentForm $student
 * @property StudentForm $students
 */
class EducationCreateForm extends CompositeForm
{
    public $title;
    public $description;
    public $color;
    public $start;
    public $end;

    public function __construct($config = [])
    {
        $this->teacher = new TeacherForm();
        $this->student = new StudentForm();
        $this->students = new StudentForm();
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