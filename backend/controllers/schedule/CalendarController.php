<?php


namespace backend\controllers\schedule;


use yii\web\Controller;

class CalendarController extends Controller
{


    public function actionCalendar(): string
    {

        return $this->render('calendar');
    }

}