<?php


namespace schedule\readModels\Schedule;


use schedule\entities\Schedule\Event\Education;
use yii\db\Expression;

class EducationReadRepository
{
    public function getAll(): array
    {
        return Education::find()->with(['teacher','student'])->all();
    }

    public function find($id): ?Education
    {
        return Education::find()->with(['teacher','student'])->andWhere(['id' => $id])->one();
    }

    public function getLessonDayById($id)
    {
        return Education::find()->with('teacher','student')
            ->andwhere(['DATE(start)'=>new Expression('DATE(NOW())')])
            ->andWhere(['LIKE','student_ids', $id ])
            ->all();

    }
}