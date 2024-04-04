<?php


namespace schedule\cart\storage;


use schedule\cart\CartItem;
use schedule\entities\Schedule\Event\ServiceAssignment;
use yii\db\Connection;
use yii\db\Query;


/**
 * A class for loading and storing events in the database
 */
class DbStorage implements StorageInterface
{
    private $userId;
    private $db;

    public function __construct($userId, Connection $db)
    {
        $this->userId = $userId;
        $this->db = $db;
    }

    public function load(): array
    {
        $query = (new Query())
            ->select(['event_id', 'service_id', 'DATE(start) as start'])
            ->from('{{%schedule_service_assignments}}')
            ->leftJoin('{{%schedule_events}}', 'id=event_id');
        if (\Yii::$app->id == 'app-frontend') {
            $query->where(['master_id' => $this->userId->id]);
        }
        $rows = $query->orderBy('DATE(start)')
            ->all(\Yii::$app->db);


        return array_map(
            function (array $row) {
                /** @var ServiceAssignment $item */
                if ($item = ServiceAssignment::find()
                    ->alias('sa')
                    ->select(
                        [
                            'event_id',
                            'service_id',
                            'cost',
                            'DATE(schedule_events.start) as start'
                        ]
                    )
                    ->joinWith(
                        [
                            'events',
                            'services s' => function ($q) {
                                //$q->select(['s.id','name', 'price_new']);
                                $q->joinWith('category ca');
                            },
                            'events.employee' => function ($q) {
                                $q->select(['color', 'rate_id', 'price_id','first_name','last_name']);
                                $q->joinWith('rate r');
                                $q->joinWith('price p');
                            },
                            'events.master'=> function ($q) {
                                $q->select(['username']);
                            },
                            'events.client'=> function ($q) {
                                $q->select(['username', 'discount']);
                            }
                        ]
                    )
                    ->andWhere(['service_id' => $row['service_id'], 'event_id' => $row['event_id']])
                    ->groupBy(['start', 'event_id', 'service_id'])
                    ->one()) {
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