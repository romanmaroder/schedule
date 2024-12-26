<?php


namespace core\helpers;


use core\entities\Blog\Post\Post;
use JetBrains\PhpStorm\ArrayShape;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class PostHelper
{
    #[ArrayShape([Post::STATUS_DRAFT => "string", Post::STATUS_ACTIVE => "string"])]
    public static function statusList(): array
    {
        return [
            Post::STATUS_DRAFT => \Yii::t('app','Draft'),
            Post::STATUS_ACTIVE => \Yii::t('app','Active'),
        ];
    }

    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status): string
    {
        $class = match ($status) {
            Post::STATUS_DRAFT => 'badge bg-secondary bg-gradient text-shadow box-shadow',
            Post::STATUS_ACTIVE => 'badge bg-success bg-gradient text-shadow box-shadow',
            default => 'badge bg-secondary bg-gradient text-shadow box-shadow',
        };

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }
}