<?php


namespace core\readModels\Schedule;


use core\entities\Schedule\Event\FreeTime;
use yii\db\Expression;

class FreeTimeReadRepository
{
    public function getAll(): array
    {
        return FreeTime::find()->with('additional', 'master')->all();
    }

    public function getAllById($id): array
    {
        return FreeTime::find()->with('additional', 'master')->where(['master_id' => $id])->all();
    }

    public function getAllDayById($id): array
    {
        return FreeTime::find()->with('additional', 'master')
            ->andwhere(['DATE(start)'=>new Expression('DATE(NOW())')])
            ->andWhere(['master_id' => $id])
            ->all();
    }

    public function getAllWeekById($id):array
    {
        return FreeTime::find()->with('additional','master')
            ->andwhere(['between','start',new Expression('CURDATE()'),new Expression('DATE_ADD(CURDATE(), INTERVAL 1 WEEK)')])
            ->andWhere(['master_id' => $id])
            ->all();
    }

    public function getAllEventsCount(): bool|int|string|null
    {
        return FreeTime::find()->count();
    }

    public function getEventsCount($id): bool|int|string|null
    {
        return FreeTime::find()->andWhere(['master_id'=>$id])->count();
    }

    public function getEventsCountToday($id): bool|int|string|null
    {
        return FreeTime::find()
            ->andwhere(['DATE(start)'=>new Expression('DATE(NOW())')])
            ->andWhere(['master_id'=>$id])->count();
    }

    /*public function findRecordsFromTodayDate(): array
    {
        return FreeTime::find()
            ->joinWith('client c')
            ->select(['c.id', 'c.username'])
            ->where(['>=','DATE(start)',new Expression('DATE(NOW() + INTERVAL 1 DAY)')])
            ->asArray()
            ->all();
    }*/

    public function getUnpaidRecords(): array
    {
       return FreeTime::find()->where(['status'=>0])->all();
    }

    public function find($id): ?FreeTime
    {
        return FreeTime::find()->andWhere(['master_id' => $id])->one();
    }
}