<?php


namespace core\cart\schedule\storage;


use core\cart\schedule\CartItem;
use core\entities\Schedule\Event\Event;
use core\entities\Schedule\Event\ServiceAssignment;
use yii\caching\TagDependency;
use yii\db\Connection;
use yii\db\Query;


/**
 * A class for loading and storing events in the database
 */
class DbStorage implements StorageInterface
{

    public function __construct(private $userId, private readonly Connection $db)
    {
    }


    public function load(): array
    {

        if (!empty($params['from_date']) || !empty($params['to_date'])) {

            $rows= ServiceAssignment::getDb()->cache(function () use ($params) {
                $query = ServiceAssignment::find()
                    ->joinWith(['events.client','events.employee','events.master'])
                    ->joinWith(['services']);

                if (\Yii::$app->id == 'app-frontend') {
                    $query->where(['master_id' => $this->userId->id]);
                }

                $query->andFilterWhere(['between', 'DATE(start)', $params['from_date'], $params['to_date']]);

                return $query->orderBy(['DATE(start)' => SORT_ASC])
                    ->all();
            }, 0, new TagDependency(['tags' => Event::CACHE_KEY]));

            return array_map(function ($row) {
                return new CartItem($row);
            },$rows );
        } else {
            return [];
        }

//        $query = (new Query())
//            ->select([
//                         '*',
//                         'DATE(start) as start'
//                     ])
//            ->from('{{%schedule_service_assignments}}')
//            ->leftJoin('{{%schedule_events}}', 'id=event_id');
//        if (\Yii::$app->id == 'app-frontend') {
//            $query->where(['master_id' => $this->userId->id]);
//        }
//        $rows = $query->orderBy(['DATE(start)' => SORT_ASC])
//            ->all($this->db);
//
//        return array_map(
//            function (array $row) {
//                /** @var ServiceAssignment $item */
//
//                if ($item = ServiceAssignment::getDb()->cache(function ($db) use ($row) {
//                    return ServiceAssignment::find()
//                        ->where([
//                                    'service_id' => $row['service_id'],
//                                    'event_id' => $row['event_id'],
//                                ])->one();
//                }, 0, new TagDependency(['tags' => Event::CACHE_KEY]))) {
//                    return new CartItem($item);
//                }
//                return false;
//            },
//            $rows
//        );
    }

    public function loadWithParams(array $params): array
    {
        return [];
    }

    public function save(array $items): void
    {
        /*$this->db->createCommand()->delete('{{%shop_cart_items}}', [
            'user_id' => $this->userId,
        ])->execute();

        $this->db->createCommand()->batchInsert(
            '{{%shop_cart_items}}',
            [
                'user_id',
                'product_id',
                'modification_id',
                'quantity'
            ],
            array_map(function (CartItem $item) {
                return [
                    'user_id' => $this->userId,
                    'product_id' => $item->getProductId(),
                    'modification_id' => $item->getModificationId(),
                    'quantity' => $item->getQuantity(),
                ];
            }, $items)
        )->execute();*/
    }


}