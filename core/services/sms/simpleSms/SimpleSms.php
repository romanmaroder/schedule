<?php


namespace core\services\sms\simpleSms;


use core\helpers\tHelper;
use core\services\sms\SmsSender;
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

    public function send($data, $text, $flag = null): string
    {
        return $this->smsLink($data, $text, $flag);
    }

    public function triggerButton($text)
    {
        if ($text == SmsMessage::INFO) {
            $options = [
                'class' => 'btn btn-info btn-sm d-inline-block mr-1',
                'id' => SmsMessage::INFO,
                'title' => self::title($text),
            ];
            return Html::tag('button', $this->smsMessage->icon($text), $options);
        }
    }

    private function smsLink($data, $text, $flag): string
    {
        if ($flag == SmsMessage::FLAG_TELEGRAM) {
            $options = [
                'class' => 'btn btn-info btn-sm d-inline-block mr-1',
                'href'  => 'https://t.me/share/url?url='.rawurlencode( $this->smsMessage->message($text, $data)),
                'title' => self::title($text),
            ];

            return Html::tag('a', $this->smsMessage->icon($text), $options);
        }

        if ($data->client->phone) {
            $options = [
                'class' => 'btn btn-info btn-sm d-inline-block mr-1',
                'href' => 'sms:' . $data->client->phone . $this->smsOs->checkOperatingSystem() .
                    $this->smsMessage->message($text, $data),
                'title' => self::title($text),
            ];

            return Html::tag('a', $this->smsMessage->icon($text), $options);
        }
        return '';
    }

    private static function titleList(): array
    {
        return [
            SmsMessage::ADDRESS_MESSAGE => tHelper::translate('sms','AddressTitle'),
            SmsMessage::REMAINDER_MESSAGE => tHelper::translate('sms','EventTitle'),
            SmsMessage::QUESTION_MESSAGE => tHelper::translate('sms','ConfirmationTitle'),
            SmsMessage::PRICE_MESSAGE => tHelper::translate('sms','PriceTitle'),
            SmsMessage::INFO => tHelper::translate('sms','InfoTitle'),
            SmsMessage::FLAG_TELEGRAM => tHelper::translate('sms','Telegram'),
        ];
    }

    private static function title($text): string
    {
        return ArrayHelper::getValue(self::titleList(), $text);
    }


}