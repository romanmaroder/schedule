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
class DbStorageWithParams implements StorageInterface
{
    private $userId;
    private $db;

    public function __construct($userId, Connection $db)
    {
        $this->userId = $userId;
        $this->db = $db;
    }


    public function load(): array
    { }

    public function loadWithParams(array $params): array
    {
        if (!empty($params['from_date']) || !empty($params['to_date'])) {
            $query = (new Query())
                ->select(['*', 'DATE(schedule_events.start) as start', 'DATE(schedule_events.end) as end'])
                ->from('{{%schedule_service_assignments}}')
                ->leftJoin('{{%schedule_events}}', 'id=event_id')
                ->andFilterWhere(['between', 'DATE(start)', $params['from_date'], $params['to_date']]);
            $rows = $query->orderBy(['DATE(start)' => SORT_ASC])
                ->all($this->db);
        }else{
        $rows = [];
        }
        return array_map(
            function (array $row) {
                /** @var ServiceAssignment $item */

                /* $item = ServiceAssignment::find()
                    ->where(['service_id' => $row['service_id'],
                                'event_id' => $row['event_id'],
                            ])->one()*/

                if ($item = ServiceAssignment::getDb()->cache(function ($db) use($row) {
                    return  ServiceAssignment::find()
                        ->where(['service_id' => $row['service_id'],
                                    'event_id' => $row['event_id'],
                                ])->one();
                },0,new TagDependency(['tags' => Event::CACHE_KEY]))) {
                    return new CartItem($item);
                }
                return false;
            },
            $rows
        );
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