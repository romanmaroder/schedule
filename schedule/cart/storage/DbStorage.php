<?php


namespace schedule\cart\storage;


use schedule\cart\CartItem;
use schedule\entities\Schedule\Event\Event;
use yii\db\Connection;
use yii\db\Query;

class DbStorage implements StorageInterface
{
    private $userId;
    private $db;

    public function __construct ($userId, Connection $db)
    {
        $this->userId = $userId;
        $this->db = $db;
    }

    public function load(): array
    {
        $query = (new Query())
            ->select('id')
            ->from('{{%schedule_events}}');
        if (\Yii::$app->id == 'app-frontend') {
            $query->where(['master_id' => $this->userId->id]);
            }
        $rows= $query->orderBy('DATE(start)')
            ->all(\Yii::$app->db);


        return array_map(
            function (array $row) {
                /** @var Event $event */
                if ($event = Event::find()
                    ->with(['employee'])
                    ->andWhere(['id' => $row['id']])
                    ->one()) {
                    return new CartItem($event);
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