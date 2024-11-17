<?php


namespace core\services\messengers\sms;


class OperatingSystemDefinition
{
    public const IOS = '&body=';
    public const ANDROID = '?body=';

    /**
     * Checking what operating system the user is using
     *
     * @return  string
     * @property $params
     */
    final public function checkOS(): string
    {
        preg_match("/iPhone|Android|iPad|iPod|webOS/", $_SERVER['HTTP_USER_AGENT'], $matches);
        $os = current($matches);

        switch ($os) {
            case 'iPod':
            case 'iPhone':
            case 'iPad':
                $params = self::IOS;
                break;
            case 'Android':
                $params = self::ANDROID;
                break;
            default:
                $params = self::ANDROID;
        }
        return $params;

        /* $params = match ($os) {
            'iPod', 'iPhone', 'iPad' => self::IOS,
            'Android' => self::ANDROID,
            default => self::ANDROID,
        };
        return $params;*/
    }
}