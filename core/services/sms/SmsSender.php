<?php


namespace core\services\sms;


interface SmsSender
{
    public function send($data, $text);
}