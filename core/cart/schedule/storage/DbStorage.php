<?php


namespace core\cart\schedule\storage;


use core\cart\schedule\CartItem;
use core\entities\Schedule\Event\Event;
use core\entities\Schedule\Event\ServiceAssignment;
use yii\caching\TagDependency;
use yii\db\Connection;


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

        $rows= ServiceAssignment::getDb()->cache(function () {
            $query = ServiceAssignment::find()
                ->joinWith(['events.client','events.employee','events.master'])
                ->joinWith(['services']);

            if (\Yii::$app->id == 'app-frontend') {
                $query->where(['master_id' => $this->userId->id]);
            }

            return $query->orderBy(['DATE(start)' => SORT_ASC])
                ->all();
        }, 0, new TagDependency(['tags' => Event::CACHE_KEY]));

            return array_map(function ($row) {
                return new CartItem(
                    $row
                );
            },$rows);

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