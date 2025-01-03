<?php


namespace frontend\controllers\schedule\calendar;


use core\entities\Schedule\Event\Event;
use yii\web\Controller;

class CalendarController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\PageCache',
                'only' => ['index'],
                'duration' => 3600,
                'variations' => [
                    \Yii::$app->user->getId()
                ],
                'dependency' => [
                    'class' => 'yii\caching\TagDependency',
                    'tags' => Event::CACHE_KEY,
                ]
            ]
        ];
    }

    public function actionIndex(): string
    {

        return $this->render('index');
    }
}