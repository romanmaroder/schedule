<?php


namespace core\repositories\Schedule;


use core\entities\Schedule\Event\Education;
use core\repositories\NotFoundException;

class EducationRepository
{
    public function get($id): Education
    {
        if (!$education = Education::findOne($id)) {
            throw new NotFoundException('Lesson is not found.');
        }
        return $education;
    }

    public function save(Education $education):void
    {
        if (!$education->save()){
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Education $education):void
    {
        if (!$education->delete()){
            throw new \RuntimeException('Removing error.');
        }
    }
}