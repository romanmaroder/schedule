<?php


namespace core\entities\User;


use core\entities\Schedule\Service\Service;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class MultiPrice
 * @property int $id
 * @property string $name
 * @property int $rate
 * @property ServiceAssignment[] $serviceAssignments
 * @property Service $services
 */
class MultiPrice extends ActiveRecord
{
    public static function create($name, $rate): self
    {
        $price = new static();
        $price->name = $name;
        $price->rate = $rate;
        return $price;
    }

    public function edit($name, $rate): void
    {
        $this->name = $name;
        $this->rate = $rate;
    }

    public function simple( $rate): void
    {
        $this->rate = $rate;
    }


    public function assignService($id, $rate, $price): void
    {
        $assignments = $this->serviceAssignments;
        foreach ($assignments as $assignment) {
            if ($assignment->isIdEqualTo($id)) {
                return ;
            }
        }
        $assignments[] = ServiceAssignment::create($id, $rate, $price);
        $this->serviceAssignments = $assignments;
    }

    public function revokeService($id): void
    {
        $assignments = $this->serviceAssignments;
        foreach ($assignments as $i => $assignment) {
            if ($assignment->isForEvent($id)) {
                unset($assignments[$i]);
                $this->serviceAssignments = $assignments;
                return;
            }
        }
        throw new \DomainException('Assignment is not found.');
    }

    public function revokeServices(): void
    {
        $this->serviceAssignments = [];
    }

    public function cost($serviceCost, $rate=null)
    {
        if(!$rate){

            return $serviceCost - $this->rate;
        }
        return $serviceCost - $rate;
    }



    /**
     * @return ActiveQuery
     */
    public function getServiceAssignments(): ActiveQuery
    {
        return $this->hasMany(ServiceAssignment::class, ['price_id' => 'id']);
    }

    public function getServices(): ActiveQuery
    {
        return $this->hasMany(Service::class, ['id' => 'service_id'])
            ->viaTable('schedule_multiprice_assignments', ['price_id' => 'id']);
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'serviceAssignments',
                ],
            ],
        ];
    }

    public function transactions(): array
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function tableName(): string
    {
        return '{{%schedule_multiprices}}';
    }
}