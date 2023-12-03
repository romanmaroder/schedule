<?php


namespace schedule\entities\Schedule\Event;


use schedule\entities\User\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $teacher_id
 * @property int $student_id
 * @property string $title
 * @property string $description
 * @property string $color
 * @property int $start
 * @property int $end
 * @property int $status
 * @property User $teacher
 * @property User $student
 */
class Education extends ActiveRecord
{
    public static function create($teacherId, $studentId, $title, $description, $color, $start, $end): self
    {
        $education = new static();
        $education->teacher_id = $teacherId;
        $education->student_id = $studentId;
        $education->title = $title;
        $education->description = $description;
        $education->color = $color;
        $education->start = $start;
        $education->end = $end;
        return $education;
    }

    public function edit($teacherId, $studentId, $title, $description, $color, $start, $end): void
    {
        $this->teacher_id = $teacherId;
        $this->student_id = $studentId;
        $this->title = $title;
        $this->description = $description;
        $this->color = $color;
        $this->start = $start;
        $this->end = $end;
    }

    public function getTeacher(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'teacher_id']);
    }

    public function getStudent(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'student_id']);
    }

    public static function tableName(): string
    {
        return '{{%schedule_educations}}';
    }
}
