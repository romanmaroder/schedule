<?php


namespace schedule\readModels\Schedule;


use schedule\entities\Schedule\Event\Event;
use yii\db\Expression;

class EventReadRepository
{
    public function getAll(): array
    {
        return Event::find()->with('services', 'employee', 'master', 'client')->all();
    }

    public function getAllById($id): array
    {
        return Event::find()->with('services', 'employee', 'master', 'client')->where(['master_id' => $id])->all();
    }

    public function getAllDayById($id): array
    {
        return Event::find()->with('services', 'employee', 'master', 'client')
            ->andwhere(['DATE(start)'=>new Expression('DATE(NOW())')])
            ->andWhere(['master_id' => $id])
            ->all();
    }

    public function getAllWeekById($id):array
    {
        return Event::find()->with('services', 'employee', 'master', 'client')
            ->andwhere(['between','start',new Expression('CURDATE()'),new Expression('DATE_ADD(CURDATE(), INTERVAL 1 WEEK)')])
            ->andWhere(['master_id' => $id])
            ->all();
    }

    public function getAllEventsCount(): bool|int|string|null
    {
        return Event::find()->count();
    }

    public function getEventsCount($id): bool|int|string|null
    {
        return Event::find()->andWhere(['master_id'=>$id])->count();
    }

    public function getEventsCountToday($id): bool|int|string|null
    {
        return Event::find()
            ->andwhere(['DATE(start)'=>new Expression('DATE(NOW())')])
            ->andWhere(['master_id'=>$id])->count();
    }

    public function getUnpaidRecords(): array
    {
       return Event::find()->where(['status'=>0])->all();
    }

    public function getCash()
    {
        return Event::find()->where(['payment'=>2])->sum('amount');
    }

    public function getCard()
    {
        return Event::find()->where(['payment'=>3])->sum('amount');
    }

    public function find($id): ?Event
    {
        return Event::find()->andWhere(['master_id' => $id])->one();
    }
}