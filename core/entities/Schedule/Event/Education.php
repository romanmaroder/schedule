<?php


namespace core\entities\Schedule\Event;


use core\entities\User\User;
use core\helpers\tHelper;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * @property int $id
 * @property int $teacher_id
 * @property string $student_ids [json]
 * @property string $title
 * @property string $description
 * @property string $color
 * @property int $start
 * @property int $end
 * @property int $status
 * @property User $teacher
 * @property User $student
 * @property array $studentsIds
 * @property User[] $students
 */
class Education extends ActiveRecord
{
    public array $studentsIds;

    public static function create($teacherId, array $studentsIds, $title, $description, $color, $start, $end): self
    {
        $education = new static();
        $education->teacher_id = $teacherId;
        $education->studentsIds = $studentsIds;
        $education->title = $title;
        $education->description = $description;
        $education->color = $color;
        $education->start = $start;
        $education->end = $end;
        return $education;
    }

    public function edit($teacherId,  array $studentsIds, $title, $description, $color, $start, $end): void
    {
        $this->teacher_id = $teacherId;
        $this->studentsIds = $studentsIds;
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

    public function getStudents(): ActiveQuery
    {
        return $this->hasMany(User::class, ['id' => 'studentsIds']);
    }

    public function attributeLabels(): array
    {
        return [
            'teacher_id' => tHelper::translate('schedule/education','Teacher'),
            'student_ids' => tHelper::translate('schedule/education','Students'),
            'title' => tHelper::translate('schedule/education','Title'),
            'description' => tHelper::translate('schedule/education','Description'),
            'color' => tHelper::translate('schedule/education','Color'),
            'start' => tHelper::translate('schedule/education','Start'),
            'end' => tHelper::translate('schedule/education','End'),
        ];
    }

    public static function tableName(): string
    {
        return '{{%schedule_educations}}';
    }

    public function afterFind(): void
    {
        $this->studentsIds = array_filter(Json::decode($this->getAttribute('student_ids')));
        parent::afterFind();
    }

    public function beforeSave($insert):bool
    {
        $this->setAttribute('student_ids', Json::encode(array_filter($this->studentsIds)));
        return parent::beforeSave($insert);
    }
}
