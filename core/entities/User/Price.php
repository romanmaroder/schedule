<?php


namespace core\entities\User;


use core\entities\Schedule\Service\Service;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Price
 * @property int $id
 * @property string $name
 * @property int $rate
 * @property ServiceAssignment[] $serviceAssignments
 * @property Service[] $services
 */
class Price extends ActiveRecord
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

    public function assignService($id, $rate, $price): void
    {
        $assignments = $this->serviceAssignments;
        foreach ($assignments as $assignment) {
            if ($assignment->isForService($id)) {
                return;
            }
        }
        $assignments[] = ServiceAssignment::create($id, $rate, $price);
        $this->serviceAssignments = $assignments;
    }

    public function revokeService($id, $service_id): void
    {
        $assignments = $this->serviceAssignments;
        foreach ($assignments as $i => $assignment) {
            if ($assignment->isForPrice($id) && $assignment->isForService($service_id)) {
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

    /*public function getService($id, $service_id)
    {
        $assignments = $this->serviceAssignments;
        foreach ($assignments as $i => $assignment) {
            if ($assignment->isForPrice($id) && $assignment->isForService($service_id)) {
                return $assignment->getServices()->one();
            }
        }
        throw new \DomainException('Assignment is not found.');
    }*/

    public function getService($id, $service_id)
    {
        $assignments = $this->serviceAssignments;
        foreach ($assignments as $i => $assignment) {
            if ($assignment->isForPrice($id) && $assignment->isForService($service_id)) {
                return $assignment->getAssignments($id,$service_id);
            }
        }
        throw new \DomainException('Assignment is not found.');
    }


    public function cost($serviceCost, $rate = null)
    {
        return $serviceCost - $this->checkRate($serviceCost, $rate);
    }

    public function checkRate($serviceCost, $rate): int
    {
        if ($rate == null) {
            $rate = $this->rate;
        }
        if ($rate >= $serviceCost) {
            return 0;
        }
        return $rate;
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