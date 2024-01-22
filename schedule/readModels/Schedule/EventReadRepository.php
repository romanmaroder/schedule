<?php


namespace schedule\readModels\Schedule;


use schedule\entities\Schedule\Event\Event;
use yii\db\ActiveQuery;

class EventReadRepository
{
    public function getAll(): array
    {
        return Event::find()->with('services','employee','master','client')->all();

    }

    public function getAllById($id):array
    {
        return Event::find()->with('services','employee','master','client')->andWhere(['master_id' => $id])->all();
    }

    public function find($id): ?Event
    {
        return Event::find()->andWhere(['master_id' => $id])->one();
    }
}