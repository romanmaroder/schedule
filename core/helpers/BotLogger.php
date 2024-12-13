<?php


namespace core\helpers;

class BotLogger
{
    public static function Logger($path, $error)
    {
        $log = json_encode($error, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents($path, $log);
    }

    public static function getLog($path)
    {
        $log = file_get_contents($path);
        return json_decode($log);
    }
}