<?php


namespace backend\controllers\schedule;


use core\entities\Schedule\Event\Event;
use yii\web\Controller;

class CalendarController extends Controller
{
    /*public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\PageCache',
                'only' => ['calendar'],
                'duration' => 3600,
                'dependency' => [
                    'class' => 'yii\caching\TagDependency',
                    'tags' => Event::CACHE_KEY,
                ]
            ]
        ];
    }*/

    public function actionCalendar(): string
    {
        return $this->render('calendar');
    }

}