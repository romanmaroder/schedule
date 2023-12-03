<?php


namespace schedule\readModels\Schedule;


use schedule\entities\Schedule\Event\Education;

class EducationReadRepository
{
    public function getAll(): array
    {
        return Education::find()->with(['teacher', 'student'])->all();
    }

    public function find($id): ?Education
    {
        return Education::find()->andWhere(['id' => $id])->one();
    }
}