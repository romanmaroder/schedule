<?php


namespace core\services\sms\shop;


interface SmsSender
{
    public function send($number, $text): void;
}