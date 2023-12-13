<?php


namespace schedule\services\manage\Schedule;


use schedule\entities\Schedule\Event\Education;
use schedule\forms\manage\Schedule\Event\EducationCreateForm;
use schedule\forms\manage\Schedule\Event\EducationEditForm;
use schedule\repositories\Schedule\EducationRepository;

class EducationManageService
{
    private EducationRepository $educations;

    public function __construct(EducationRepository $educations)
    {
        $this->educations = $educations;
    }

    public function create(EducationCreateForm $form): Education
    {
        $education = Education::create(
            $form->teacher->teacher,
            $form->students->students,
            $form->title,
            $form->description,
            $form->color,
            $form->start,
            $form->end,
        );
        $this->educations->save($education);
        return $education;
    }

    public function edit($id, EducationEditForm $form):void
    {
        $education = $this->educations->get($id);
        $education->edit(
            $form->teacher->teacher,
            $form->students->students,
            $form->title,
            $form->description,
            $form->color,
            $form->start,
            $form->end,
        );
        $this->educations->save($education);
    }

    public function remove($id):void
    {
        $education = $this->educations->get($id);
        $this->educations->remove($education);
    }
}