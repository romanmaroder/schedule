<?php


namespace schedule\helpers;


use schedule\entities\Blog\Post\Post;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class PostHelper
{
    public static function statusList(): array
    {
        return [
            Post::STATUS_DRAFT => 'Draft',
            Post::STATUS_ACTIVE => 'Active',
        ];
    }

    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status): string
    {
        switch ($status) {
            case Post::STATUS_DRAFT:
                $class = 'badge bg-secondary bg-gradient text-shadow box-shadow';
                break;
            case Post::STATUS_ACTIVE:
                $class = 'badge bg-success bg-gradient text-shadow box-shadow';
                break;
            default:
                $class = 'badge bg-secondary bg-gradient text-shadow box-shadow';
        }

        /*$class = match ($status) {
            Post::STATUS_DRAFT => 'badge bg-default bg-gradient text-shadow box-shadow',
            Post::STATUS_ACTIVE => 'badge bg-success bg-gradient text-shadow box-shadow',
            default => 'badge bg-default bg-gradient text-shadow box-shadow',
        };*/

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }
}