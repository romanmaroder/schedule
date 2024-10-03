<?php


namespace core\forms\manage\Schedule\Event;


use core\forms\CompositeForm;
use core\helpers\tHelper;

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
        $this->students = new StudentForm();
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['start', 'end'], 'required'],
            [['title', 'description', 'color'], 'string'],
            [['color'], 'default', 'value' => '#474D2A'],
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
        return ['teacher','students'];
    }
}