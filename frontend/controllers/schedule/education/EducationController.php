<?php


namespace frontend\controllers\schedule\education;


use core\entities\Schedule\Event\Calendar\Calendar;
use core\entities\Schedule\Event\Education;
use core\repositories\NotFoundException;
use core\useCases\manage\Schedule\EducationManageService;
use yii\web\Controller;
use yii\web\Response;

class EducationController extends Controller
{
    public function __construct(
        $id,
        $module,
        private EducationManageService $service,
        private readonly Calendar $calendar,
        $config = [])
    {
        parent::__construct($id, $module, $config);
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