<?php


namespace core\entities\behaviors;


use core\entities\Address;
use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class AddressBehavior extends Behavior
{
    public $attribute = 'address';
    public $jsonAttribute = 'address_json';

    public function events(): array
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'onAfterFind',
            ActiveRecord::EVENT_BEFORE_INSERT => 'onBeforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'onBeforeSave',
        ];
    }

    public function onAfterFind(Event $event): void
    {
        $model = $event->sender;
        $address = Json::decode($model->getAttribute($this->jsonAttribute));
        $model->{$this->attribute} = new Address(
            ArrayHelper::getValue($address, 'town'),
            ArrayHelper::getValue($address, 'borough'),
            ArrayHelper::getValue($address, 'street'),
            ArrayHelper::getValue($address, 'home'),
            ArrayHelper::getValue($address, 'apartment'),
        );
    }


    /**
     * @param Event $event
     */
    public function onBeforeSave(Event $event): void
    {
        $model = $event->sender;
        $model->setAttribute(
            'address_json',
            Json::encode(
                [
                    'town' => $model->{$this->attribute}->town,
                    'borough' => $model->{$this->attribute}->borough,
                    'street' => $model->{$this->attribute}->street,
                    'home' => $model->{$this->attribute}->home,
                    'apartment' => $model->{$this->attribute}->apartment,
                ]
            )
        );
    }
}