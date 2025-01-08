<?php


namespace core\entities\Schedule\Event;


use core\entities\Schedule\Additional\Additional;
use core\entities\User\Employee\Employee;
use core\entities\User\User;
use core\helpers\tHelper;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
/**
 * @property int $id
 * @property int $master_id
 * @property int $additional_id
 * @property int $start
 * @property int $end
 * @property string $notice
 *
 */
class FreeTime extends ActiveRecord
{

    public static function create(
        $masterId,
        $additionalId,
        $start,
        $end,
        $notice
    ): self {
        $freeTime = new static();
        $freeTime->master_id = $masterId;
        $freeTime->additional_id = $additionalId;
        $freeTime->start = $start;
        $freeTime->end = $end;
        $freeTime->notice = $notice;
        return $freeTime;
    }

    public function edit(
        $masterId,
        $additionalId,
        $start,
        $end,
        $notice,
    ): void {
        $this->master_id = $masterId;
        $this->additional_id = $additionalId;
        $this->start = $start;
        $this->end = $end;
        $this->notice = $notice;
    }

    public static function copy(
        $id,
        $masterId,
        $additionalId,
        $start,
        $end,
        $notice
    ): self {
        $freeTime = new static();
        $freeTime->id = $id;
        $freeTime->master_id = $masterId;
        $freeTime->additional_id = $additionalId;
        $freeTime->start = $start;
        $freeTime->end = $end;
        $freeTime->notice = $notice;
        return $freeTime;
    }

    public function copied(): FreeTime

    {
        return clone $this;
    }

    public function getMaster(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'master_id']);
    }

    public function getEmployee(): ActiveQuery
    {
        return $this->hasOne(Employee::class,['user_id'=>'master_id']);
    }
    public function getAdditional(): ActiveQuery
    {
        return $this->hasOne(Additional::class,['id'=>'additional_id']);
    }

    public function attributeLabels(): array
    {
        return [
            'master_id' => tHelper::translate('schedule/free','Master'),
            'additional_id' => tHelper::translate('schedule/free','Additional'),
            'start' => tHelper::translate('schedule/free','Start'),
            'end' => tHelper::translate('schedule/free','End'),
            'notice' => tHelper::translate('schedule/free','Notice'),
            'copy' => tHelper::translate('app','Copy'),
        ];
    }

    public static function tableName(): string
    {
        return '{{%schedule_free_time}}';
    }

}