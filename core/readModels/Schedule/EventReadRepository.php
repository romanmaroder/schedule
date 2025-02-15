<?php


namespace core\readModels\Schedule;


use core\entities\Enums\PaymentOptionsEnum;
use core\entities\Enums\StatusPayEnum;
use core\entities\Schedule\Event\Event;
use core\useCases\Schedule\CacheService;
use yii\caching\TagDependency;
use yii\db\Expression;

class EventReadRepository
{
    private $cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    public function getAll(): array
    {
        $key = Event::CACHE_KEY;
        $query = Event::find()->with('services', 'employee', 'master', 'client');

        return $this->cacheService->cache->getOrSet($key, function () use ($query) {
            return $query->all();
        }, 0, new TagDependency([
            'tags' => Event::CACHE_KEY
        ]));
    }

    /*public function getAll(): array
    {
        return Event::find()->with('services', 'employee', 'master', 'client')->all();
    }*/


    public function getAllById($id): array
    {
        $key = Event::CACHE_KEY;
        $query = Event::find()->with('services', 'employee', 'master', 'client')->where(['master_id' => $id]);

        return $this->cacheService->cache->getOrSet($key, function () use ($query) {
            return $query->all();
        }, 0, new TagDependency([
            'tags' => Event::CACHE_KEY
        ]));
    }

    /*public function getAllById($id): array
    {
        return Event::find()->with('services', 'employee', 'master', 'client')->where(['master_id' => $id])->all();
    }*/

    /*public function getAllDayById($id): array
    {
        $key = Event::CACHE_KEY;
        $query = Event::find()->with('services', 'employee', 'master', 'client')
            ->where(['DATE(start)'=>new Expression('DATE(NOW())')])
            ->andWhere(['master_id' => $id]);

        return $this->cacheService->cache->getOrSet($key, function () use ($query) {
            return $query->all();
        }, 0, new TagDependency([
            'tags' => Event::CACHE_KEY
        ]));
    }*/


    public function getAllDayById($id): array
    {
        return Event::find()->with('services', 'employee', 'master', 'client')
            ->where(['DATE(start)'=>new Expression('DATE(NOW())')])
            ->andWhere(['master_id' => $id])
            ->orderBy(['start'=>SORT_ASC])
            ->all();
    }


    /*public function getAllWeekById($id): array
    {
        $key = Event::CACHE_KEY;
        $query = Event::find()->with('services', 'employee', 'master', 'client')
            ->where(['between','start',new Expression('CURDATE()'),new Expression('DATE_ADD(CURDATE(), INTERVAL 1 WEEK)')])
            ->andWhere(['master_id' => $id]);

        return $this->cacheService->cache->getOrSet($key, function () use ($query) {
            return $query->all();
        }, 0, new TagDependency([
            'tags' => Event::CACHE_KEY
        ]));
    }*/


    public function getAllWeekById($id):array
    {
        return Event::find()->with('services', 'employee', 'master', 'client')
            ->where(['between','start',new Expression('CURDATE()'),new Expression('DATE_ADD(CURDATE(), INTERVAL 1 WEEK)')])
            ->andWhere(['master_id' => $id])
            ->orderBy(['start'=>SORT_ASC])
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

    public function findRecordsFromTodayDate(): array
    {
        return Event::find()
            ->joinWith('client c')
            ->select(['c.id', 'c.username'])
            ->where(['>=','DATE(start)',new Expression('DATE(NOW() + INTERVAL 1 DAY)')])
            ->asArray()
            ->all();
    }

    public function getUnpaidRecords(): array
    {
       return Event::find()->where(['status'=>StatusPayEnum::STATUS_NOT_PAYED])
           ->orderBy(['start' => SORT_ASC])
           ->all();
    }

    public function getCash()
    {
        return Event::find()->where(['payment'=>PaymentOptionsEnum::STATUS_CASH])->sum('amount');
    }

    public function getCard()
    {
        return Event::find()->where(['payment' => PaymentOptionsEnum::STATUS_CARD])->sum('amount');
    }

    public function find($id): ?Event
    {
        return Event::find()->andWhere(['master_id' => $id])->one();
    }

    public function findAllClientEvents($userId): array
    {
        return Event::find()
            ->select('id, start,')
            ->where(['client_id' => $userId])
            ->andWhere(['>', 'start', new Expression('CURDATE()')])
            ->orderBy(['start' => SORT_ASC])
            ->asArray()
            ->all();
    }

    public function findClientEvents($userId)
    {
        return Event::find()
            ->with('services', 'employee', 'master', 'client')
            ->where(['client_id' => $userId])
            ->orderBy(['start' => SORT_ASC])->all();
    }

    public function findOneClientEvent($id)
    {
        return Event::find()
            ->with('services', 'employee', 'master', 'client')
            ->where(['schedule_events.id' => $id])
            ->asArray()->one();
    }
}