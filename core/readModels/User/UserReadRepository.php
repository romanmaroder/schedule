<?php


namespace core\readModels\User;


use core\entities\Enums\StatusEnum;
use core\entities\User\User;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class UserReadRepository
{


    public function find($id): array|ActiveRecord
    {
        return User::find()->with(['employee'])->andWhere(['id' => $id])->one();
    }

    public function findByChatId($chatId): array|ActiveRecord
    {
        return User::find()->where(['t_chat_id'=>$chatId])->one();
    }

    public function findByUserPhone($phone): array|ActiveRecord
    {
        return User::find()
            ->where(['phone' => $phone])
            ->one();
    }

    public function findActiveById($id): ?User
    {
        return User::findOne(['id' => $id, 'status' => StatusEnum::STATUS_ACTIVE]);
    }

    public function findActiveByUsername($username): ?User
    {
        return User::findOne(['username' => $username, 'status' => StatusEnum::STATUS_ACTIVE]);
    }

    public function findMissed($eventIdsUser): ActiveDataProvider
    {
        return $this->getProvider(
            $this->findAllMissingUser(
                array_diff(
                    ArrayHelper::getColumn($this->findAllUser(), 'id'),
                    ArrayHelper::getColumn($eventIdsUser, 'id')
                )
            )
        );
    }

    private function findAllUser(): array
    {
        return User::find()->alias('u')->leftJoin('schedule_employees', 'schedule_employees.user_id = u.id')
            ->select(['u.id', 'u.username'])
            ->where(['is', 'schedule_employees.user_id', null])
            ->andWhere(['u.status'=>StatusEnum::STATUS_ACTIVE])
            ->asArray()
            ->all();
    }

    private function findAllMissingUser($ids): ActiveQuery
    {
        return User::find()->where(['in', 'id', $ids]);
    }

    private function getProvider(ActiveQuery $query): ActiveDataProvider
    {
        return new ActiveDataProvider(
            [
                'query' => $query,
                /*'sort' => [
                    'defaultOrder' => ['id' => SORT_DESC],
                    'attributes' => [
                        'id' => [
                            'asc' => ['p.id' => SORT_ASC],
                            'desc' => ['p.id' => SORT_DESC],
                        ],
                        'name' => [
                            'asc' => ['p.name' => SORT_ASC],
                            'desc' => ['p.name' => SORT_DESC],
                        ],
                        'price' => [
                            'asc' => ['p.price_new' => SORT_ASC],
                            'desc' => ['p.price_new' => SORT_DESC],
                        ],
                        'rating' => [
                            'asc' => ['p.rating' => SORT_ASC],
                            'desc' => ['p.rating' => SORT_DESC],
                        ],
                    ],
                ],*/
                'pagination' => false
            ]
        );
    }


}