<?php


namespace backend\controllers\schedule;


use backend\forms\Schedule\EventSearch;
use yii\web\Controller;

class CalendarController extends Controller
{


    public function actionCalendar(): string
    {

        return $this->render('calendar');
    }

}