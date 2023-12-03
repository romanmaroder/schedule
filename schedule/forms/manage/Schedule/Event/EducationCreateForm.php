<?php


namespace schedule\forms\manage\Schedule\Event;


use schedule\forms\CompositeForm;

/**
 * @property ServicesForm $services
 * @property TeacherForm $teacher
 * @property StudentForm $student
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
        parent::__construct($config);
    }

    public function rules():array
    {
        return [
            [['start', 'end'], 'required'],
            ['title','description','color', 'string']
        ];
    }

    protected function internalForms(): array
    {
        return ['teacher','student'];
    }
}