<?php


namespace core\services\sms\simpleSms;


use core\services\sms\SmsSender;
use JetBrains\PhpStorm\ArrayShape;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class SimpleSms implements SmsSender
{
    private SmsOs $smsOs;
    private SmsMessage $smsMessage;

    public function __construct(SmsOs $smsOs, SmsMessage $smsMessage)
    {
        $this->smsOs = $smsOs;
        $this->smsMessage = $smsMessage;
    }

    public function send($data, $text): string
    {
        return $this->smsLink($data, $text);
    }

    private function smsLink($data, $text): string
    {

        if ($data->client->phone) {
            $options = [
                'class' => 'btn btn-info btn-sm d-inline-block mr-1',
                'href' => 'sms:' . $data->client->phone . $this->smsOs->checkOperatingSystem() .
                    $this->smsMessage->message($text,$data) ,
                'title' => self::title($text),
            ];

            return Html::tag('a', $this->smsMessage->icon($text), $options);
        }
        return '';
    }

    private static function titleList(): array
    {
        return [
            SmsMessage::ADDRESS_MESSAGE => 'Address',
            SmsMessage::REMAINDER_MESSAGE => 'Event',
            SmsMessage::QUESTION_MESSAGE => 'Confirmation',
        ];
    }

    private static function title($text): string
    {
        return ArrayHelper::getValue(self::titleList(), $text);
    }


}