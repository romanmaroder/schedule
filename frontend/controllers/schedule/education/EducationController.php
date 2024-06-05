<?php


namespace frontend\controllers\schedule\education;


use core\entities\Schedule\Event\Calendar\Calendar;
use core\entities\Schedule\Event\Education;
use core\repositories\NotFoundException;
use core\services\manage\Schedule\EducationManageService;
use yii\web\Controller;
use yii\web\Response;

class EducationController extends Controller
{
    private EducationManageService $service;
    private Calendar $calendar;
    public function __construct($id, $module, EducationManageService $service, Calendar $calendar,$config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->calendar = $calendar;
    }

    public function actionLessons()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        return $this->calendar->getEducations();
    }

    public function actionView($id)
    {

        return $this->renderAjax(
            'view',
            [
                'model' => $this->findModel($id),
            ]
        );
    }

    protected function findModel($id): Education
    {
        if (($model = Education::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundException('The requested page does not exist.');
    }

}