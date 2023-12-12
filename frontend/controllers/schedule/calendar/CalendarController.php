<?php


namespace frontend\controllers\schedule\calendar;


use yii\web\Controller;

class CalendarController extends Controller
{


    public function actionIndex(): string
    {

        return $this->render('index');
    }
}